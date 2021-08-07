<?php

namespace App\Http\Controllers\Api\v1\Patient;

use App\Facades\PatientAuthenticateFacade as PatientAuth;
use App\Mail\PatientEmailVerification;
use App\Mail\PatientResetPassword;
use App\Models\Notification;
use App\Models\Patient;
use App\Models\PatientDevice;
use App\Models\PatientRecover;
use App\Transformers\PatientTransformer;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Spatie\Fractal\Facades\Fractal;

class AuthController extends PatientApiController
{
    protected $lang;

    function __construct(Request $request)
    {
        parent::__construct();
        $this->lang = $request->header('x-lang-code');
    }

    /**
     * Register new patient
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function signup(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            "first_name" => "required",
            "last_name" => "required",
            "email" => "required|email",
            "password" => "required|min:6",
            "phone" => "required",
            "gender" => "required|in:0,1",
            "birth_date" => "required|date",
            "lang" => "in:en,ar"
        ]);
        if ($validator->fails())
            return self::errify(400, ['validator' => $validator]);

        $patient = Patient::query()->where('email', $request->email)->first();

        if ($patient != null) {
            if ($this->lang == 'ar') {
                $email_exist_msg = 'البريد الإلكترونى موجود بالفعل';
            } else {
                $email_exist_msg = 'Email already exist.';
            }
            return self::errify(400, ['errors' => [$email_exist_msg]]);
        }

        $hash = md5(uniqid(rand(), true));
        $patient = new Patient;
        $patient['first_name'] = $request->input('first_name');
        $patient['last_name'] = $request->input('last_name');
        $patient['password'] = md5($request->input('password'));
        $patient['email'] = $request->input('email');
        $patient['token'] = md5(rand() . time());
        $patient['hash'] = $hash;
        $patient['phone'] = $request->input('phone');
        $patient['birth_date'] = $request->input('birth_date');
        $patient['gender'] = $request->input('gender');
        $patient['address'] = $request->input('address');
        $patient['lang'] = $request->input('lang') ? trim($request->input('lang')) : 'en';
        $patient['email_verified_at'] = null;
        $patient['phone_verified_at'] = null;
        $patient['is_active'] = true;

        $created_patient = $patient->save();

        if ($image = $request->input('image')) {
            $path = 'uploads/patients/patient_' . $patient['id'] . '/';
            $image_new_name = time() . '_' . $image->getClientOriginalName();
            $image->move($path, $image_new_name);
            $patient['image'] = $path . $image_new_name;
            $patient->save();
        }

        if ($created_patient) {
            $this->sendVerificationEmail($patient);
            if ($this->lang == 'ar') {
                $saved_msg = 'تم التسجيل بنجاح, من فضلك افحص البريد الالكترونى لتفعيل البريد';
            } else {
                $saved_msg = 'You have been signed up successfully, Please check your email to confirm it.';
            }
            return response()->json(['msg' => $saved_msg]);
        } else {
            return self::errify(400, ['errors' => ['Failed']]);
        }
    }

    /**
     * Login patient
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            "password" => "required",
            "email" => "required",
            "lang" => "in:en,ar",

            //for set device
            "device_id" => "required",
            "firebase_token" => "required",
        ]);
        if ($validator->fails()) {
            return self::errify(400, ['validator' => $validator]);
        } else {

            $patient = Patient::query()->where('email', '=', $request->input('email'))
                ->where('password', md5($request->input('password')))->first();

            if ($patient != null) {
                if ($patient->is_active == 0) {
                    if ($this->lang == 'ar') {
                        $not_active_msg = 'الحساب معطل من قبل المسئول';
                    } else {
                        $not_active_msg = 'Account is inactive from the administrator';
                    }
                    return self::errify(400, ['errors' => [$not_active_msg]]);
                }

                if ($patient->email_verified_at == null) {
                    if ($this->lang == 'ar') {
                        $email_not_verified_msg = 'البريد الإلكترونى غير مفعل';
                    } else {
                        $email_not_verified_msg = 'Email not Verified.';
                    }
                    return self::errify(400, ['errors' => [$email_not_verified_msg]]);
                }
                $patient->token = md5(rand() . time());

                //set device
                $patient_device = PatientDevice::where('PatientId', $patient->id)
                    ->where('device_unique_id', $request->input('device_id'))
                    ->first();

                if (!$patient_device) {
                    $patient_device = new PatientDevice();
                    $patient_device['created_at'] = date('Y-m-d H:i:s');
                }
                $patient_device->PatientId = $patient->id;
                $patient_device->device_unique_id = $request->input('device_id');
                $patient_device->mobile_os = $request->input('mobile_os');
                $patient_device->mobile_model = $request->input('mobile_model');
                $patient_device->last_used_at = date('Y-m-d H:i:s');
                $patient_device->is_logged_in = 1;
                $patient_device->token = $patient->token;
                $patient_device->firebase_token = $request->input('firebase_token');
                $patient_device->updated_at = date('Y-m-d H:i:s');
                $patient_device->save();
                if ($request->input('firebase_token')) {
                    \App\Helpers\FCMHelper::Subscribe_User_To_FireBase_Topic(Config::get('constants._PATIENT_FIREBASE_TOPIC'), [$request->input('firebase_token')]);
                }

                if ($request->input('lang')) {
                    $patient->lang = trim($request->input('lang'));
                } else {
                    $patient->lang = 'en';
                }
                $patient->save();

                $patient = Fractal::item($patient)
                    ->transformWith(new PatientTransformer($this->lang, [
                        'id', 'first_name', 'last_name', 'is_active', 'email', 'token', 'image', 'lang'
                    ]))
                    ->withResourceName('')
                    ->parseIncludes([])->toArray();

                $unread_notifications_count = Notification::query()
                    ->where("notifiable_id", $patient['data']['id'])
                    ->where("notifiable_type", "App\Models\Patient")
                    ->where('read_at', null)->count();
                $patient['data']['has_new_notifications'] = $unread_notifications_count > 0;

                return response()->json($patient);
            } else {
                if ($this->lang == 'ar') {
                    $invalid_credentials_msg = 'بيانات الدخول غير صحيحة';
                } else {
                    $invalid_credentials_msg = 'Please enter correct email and password!';
                }
                return self::errify(400, ['errors' => [$invalid_credentials_msg]]);
            }
        }
    }

    /**
     * Forgot password
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function forgotPassword(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), ["email" => "required|email"]);
        if ($validator->fails()) {
            return self::errify(400, ['validator' => $validator]);
        } else {
            $email = $request["email"];
            $patient = Patient::where('email', '=', $email)->first();

            if ($patient == null) {
                if ($this->lang == 'ar') {
                    $email_not_found_msg = 'البريد غير صحيح او الحساب غير موجود';
                } else {
                    $email_not_found_msg = 'Invalid Email or account doesn\'t exist.';
                }
                return self::errify(400, ['errors' => [$email_not_found_msg]]);
            } else {
                $recover = PatientRecover::query()->where('email', $patient->email)->first();
                if ($recover) {
                    if ($this->lang == 'ar') {
                        $email_already_sent_msg = 'تم ارسال البريد بالفعل من فضلك افحص بريدك';
                    } else {
                        $email_already_sent_msg = 'Reset email already sent, Please check your email';
                    }
                    return self::errify(400, ['errors' => [$email_already_sent_msg]]);
                }

                $hash = md5(uniqid(rand(), true));
                $patientRecover = new PatientRecover();
                $patientRecover['email'] = $patient->email;
                $patientRecover['hash'] = $hash;
                $patientRecover->save();

                // send Email
                global $emailTo;
                $emailTo = $patient->email;
                global $emailToName;
                $emailToName = $patient->first_name . ' ' . $patient->last_name;
                $from = env('MAIL_FROM_ADDRESS');
                Mail::to($emailTo)->send(new PatientResetPassword($patient, $hash, $from));

                if ($this->lang == 'ar') {
                    $email_sent_msg = 'تم ارسال البريد من فضلك افحص بريدك';
                } else {
                    $email_sent_msg = 'Reset email sent, Please check your email';
                }
                return response()->json(['msg' => $email_sent_msg]);
            }
        }
    }

    /**
     * Change password
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function updatePassword(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            "old_password" => "required",
            'password' => 'required|confirmed|min:6',
        ]);
        if ($validator->fails())
            return self::errify(400, ['validator' => $validator]);

        $patient_auth = PatientAuth::patient();
        $patient = Patient::query()->where('email', '=', $patient_auth->email)
            ->where('password', md5($request->input('old_password')))->first();

        if ($patient != null) {
            if ($patient->email_verified_at == null) {
                if ($this->lang == 'ar') {
                    $email_not_verified_msg = 'البريد الإلكترونى غير مفعل';
                } else {
                    $email_not_verified_msg = 'Email not Verified.';
                }
                return self::errify(400, ['errors' => [$email_not_verified_msg]]);
            }
            $patient->password = md5($request->input('password'));
            $patient->save();

            if ($this->lang == 'ar') {
                $password_changed_msg = 'تم تغيير كلمة المرور بنجاح';
            } else {
                $password_changed_msg = 'Password changed successfully!';
            }
            return response()->json(['msg' => $password_changed_msg]);
        } else {
            if ($this->lang == 'ar') {
                $invalid_old_password_msg = 'كلمة المرور القديمة غير صحيحة';
            } else {
                $invalid_old_password_msg = 'The old password is not valid!';
            }
            return self::errify(400, ['errors' => [$invalid_old_password_msg]]);
        }
    }

    /**
     * Resend verification email
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function resendEmailVerification(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), ["email" => "required|email"]);
        if ($validator->fails()) {
            return self::errify(400, ['validator' => $validator]);
        } else {
            $email = $request["email"];
            $patient = Patient::query()->where('email', '=', $email)->first();
            if ($patient == null) {
                if ($this->lang == 'ar') {
                    $email_not_found_msg = 'البريد غير صحيح او الحساب غير موجود';
                } else {
                    $email_not_found_msg = 'Invalid Email or account doesn\'t exist.';
                }
                return self::errify(400, ['errors' => [$email_not_found_msg]]);
            } else if ($patient->email_verified_at) {
                if ($this->lang == 'ar') {
                    $email_already_verified_msg = 'البريد مفعل من قبل';
                } else {
                    $email_already_verified_msg = 'Email already verified.';
                }
                return self::errify(400, ['errors' => [$email_already_verified_msg]]);
            } else {
                // send Email
                $this->sendVerificationEmail($patient);
                if ($this->lang == 'ar') {
                    $email_sent_msg = 'تم ارسال البريد, من فضلك افحص بريدك';
                } else {
                    $email_sent_msg = 'Reset email sent, Please check your email';
                }
                return response()->json(['msg' => $email_sent_msg]);
            }
        }
    }

    /**
     * Send verification email
     *
     * @param $patient
     */
    private function sendVerificationEmail($patient)
    {
        global $emailTo;
        $emailTo = $patient->email;
        global $emailToName;
        $emailToName = $patient->first_name . ' ' . $patient->last_name;
        $hash = $patient->hash;
        $from = env('MAIL_FROM_ADDRESS');
        Mail::to($emailTo)->send(new PatientEmailVerification($patient, $hash, $from));
    }

    /**
     * Signup social
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function signupSocial(Request $request): JsonResponse
    {
        //validation for old account
        $validator = Validator::make($request->all(), [
            "social_id" => "required",
            "device_id" => "required",
            "firebase_token" => "required",
            "lang" => "in:en,ar",
        ]);
        if ($validator->fails())
            return self::errify(400, ['validator' => $validator]);

        $existingPatient = Patient::query()
            ->where('facebook_id', '=', $request->input('social_id'))
            ->orWhere('google_id', '=', $request->input('social_id'))
            ->orWhere('apple_id', '=', $request->input('social_id'))
            ->first();
        if ($existingPatient) {
            $existingPatient->token = md5(rand() . time());
            $existingPatient->save();

            //set device
            $patient_device = PatientDevice::query()->where('PatientId', $existingPatient->id)
                ->where('device_unique_id', $request->device_id)
                ->first();

            if (!$patient_device) {
                $patient_device = new PatientDevice();
                $patient_device->created_at = date('Y-m-d H:i:s');
            }
            $patient_device->PatientId = $existingPatient->id;
            $patient_device->device_unique_id = $request->input('device_id');
            $patient_device->token = $existingPatient->token;
            $patient_device->firebase_token = $request->input('firebase_token');
            $patient_device->updated_at = date('Y-m-d H:i:s');
            $patient_device->save();
            if ($request->input('firebase_token')) {
                \App\Helpers\FCMHelper::Subscribe_User_To_FireBase_Topic(Config::get('constants._PATIENT_FIREBASE_TOPIC'), [$request->input('firebase_token')]);
            }

            $patient = Fractal::item($existingPatient)
                ->transformWith(new PatientTransformer($this->lang, [
                    'id', 'first_name', 'last_name', 'is_active', 'email', 'token', 'image'
                ]))
                ->withResourceName('')
                ->parseIncludes([])->toArray();

            $unread_notifications_count = Notification::query()
                ->where("notifiable_id", $patient['data']['id'])
                ->where("notifiable_type", "App\Models\Patient")
                ->where('read_at', null)->count();
            $patient['data']['has_new_notifications'] = $unread_notifications_count > 0;

            $patient['account_status'] = "Old account";

            return response()->json($patient);
        }

        //validation for new account
        $validator = Validator::make($request->all(), [
            "first_name" => "required",
            "email" => "required|email",
            "gender" => "required|in:0,1",
            "birth_date" => "required|date",
            "social_type" => "required|numeric|in:1,2,3",
            "social_id" => "required",
            "device_id" => "required",
            "firebase_token" => "required",
            "lang" => "in:en,ar",
        ]);
        if ($validator->fails())
            return self::errify(400, ['validator' => $validator]);

        if (Patient::query()->where('email', $request->input('email'))->first()) {
            if ($this->lang == 'ar') {
                $email_exist_msg = 'البريد الإلكترونى موجود بالفعل';
            } else {
                $email_exist_msg = 'Email already exist.';
            }
            return self::errify(400, ['errors' => [$email_exist_msg]]);
        }
        $newPatient = new Patient;
        $newPatient['first_name'] = $request->input('first_name');
        $newPatient['email'] = $request->input('email');
        $newPatient['token'] = md5(rand() . time());
        $newPatient['hash'] = md5(uniqid(rand(), true));
        $newPatient['phone'] = $request->input('phone');
        $newPatient['birth_date'] = $request->input('birth_date');
        $newPatient['gender'] = $request->input('gender');
        $newPatient['lang'] = $request->input('lang') ? trim($request->input('lang')) : 'en';
        $newPatient['facebook_id'] = $request->input('facebook_id') ?? "";
        $newPatient['google_id'] = $request->input('google_id') ?? "";
        $newPatient['apple_id'] = $request->input('apple_id') ?? "";
        $newPatient['email_verified_at'] = Carbon::now()->toDateTimeString();
        $newPatient['phone_verified_at'] = Carbon::now()->toDateTimeString();
        $newPatient['is_active'] = true;
        switch ($request->input('social_type')) {
            case config('constants.SOCIAL_SIGNUP_FACEBOOK'):
                $newPatient['facebook_id'] = $request->input('social_id');
                break;
            case config('constants.SOCIAL_SIGNUP_GOOGLE'):
                $newPatient['google_id'] = $request->input('social_id');
                break;
            case config('constants.SOCIAL_SIGNUP_APPLE'):
                $newPatient['apple_id'] = $request->input('social_id');
                break;
        }
        //social image url
        if ($request->input('image')) {
            $newPatient['image'] = $request->input('image');
        }
        $newPatient->save();

        if ($newPatient) {
            //set device
            $patient_device = PatientDevice::query()->where('PatientId', $newPatient['id'])
                ->where('device_unique_id', $request->input('device_id'))
                ->first();

            if (!$patient_device) {
                $patient_device = new PatientDevice();
                $patient_device->created_at = date('Y-m-d H:i:s');
            }
            $patient_device->PatientId = $newPatient['id'];
            $patient_device->device_unique_id = $request->input('device_id');
            $patient_device->token = $newPatient['token'];
            $patient_device->firebase_token = $request->input('firebase_token');
            $patient_device->updated_at = date('Y-m-d H:i:s');
            $patient_device->save();
            if ($request->input('firebase_token')) {
                \App\Helpers\FCMHelper::Subscribe_User_To_FireBase_Topic(Config::get('constants._PATIENT_FIREBASE_TOPIC'), [$request->input('firebase_token')]);
            }

            $patient = Fractal::item($newPatient)
                ->transformWith(new PatientTransformer($this->lang, [
                    'id', 'first_name', 'last_name', 'is_active', 'email', 'token', 'image'
                ]))
                ->withResourceName('')
                ->parseIncludes([])->toArray();

            $unread_notifications_count = Notification::query()
                ->where("notifiable_id", $patient['data']['id'])
                ->where("notifiable_type", "App\Models\Patient")
                ->where('read_at', null)->count();
            $patient['data']['has_new_notifications'] = $unread_notifications_count > 0;

            $patient['account_status'] = "New account";

            return response()->json($patient);
        } else
            return self::errify(400, ['errors' => ['Failed']]);
    }

    /**
     * Logout
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $token = $request->header('x-auth-token');
        $patient_device = PatientDevice::query()->where('token', $token)->first();

        if ($patient_device != null) {
            $patient_device->is_logged_in = 0;
            $patient_device->save();

            if ($this->lang == 'ar') {
                $signed_out_msg = 'تم تسجيل الخروج بنجاح';
            } else {
                $signed_out_msg = 'You have been signed out successfully';
            }
            return response()->json(['msg' => $signed_out_msg]);
        } else {
            if ($this->lang == 'ar') {
                $invalid_token_msg = 'الرمز منتهى او غير صحيح';
            } else {
                $invalid_token_msg = 'Invalid or expired Token';
            }
            return self::errify(400, ['errors' => [$invalid_token_msg]]);
        }
    }
}
