<?php

namespace App\Http\Controllers\Api\v1\Patient;

use App\Facades\PatientAuthenticateFacade as PatientAuth;
use App\Models\Patient;
use App\Transformers\PatientTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Fractal\Facades\Fractal;

class PatientsController extends PatientApiController
{
    protected $lang;

    function __construct(Request $request)
    {
        parent::__construct();
        $this->lang = $request->header('x-lang-code');
    }

    /**
     * Get patient profile
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function profile(Request $request): JsonResponse
    {
        if ($this->lang != 'en' && $this->lang != 'ar')
            return response()->json(['error' => 'invalid language code']);

        $patient = PatientAuth::patient();

        if (!$patient)
            return response()->json(['error' => [__('auth.invalid_token')]]);

        $patient = Fractal::item($patient)
            ->transformWith(new PatientTransformer($this->lang, [
                'id', 'first_name', 'last_name', 'email', 'phone', 'image',
                'birth_date', 'weight', 'height', 'gender'
            ]))
            ->withResourceName('')
            ->parseIncludes([])->toArray();

        return response()->json($patient);
    }

    /**
     * Update patient profile
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function updateProfile(Request $request): JsonResponse
    {
        if ($this->lang != 'en' && $this->lang != 'ar')
            return response()->json(['error' => 'invalid language code']);

        $patient_auth = PatientAuth::patient();
        if (!$patient_auth)
            return response()->json(['error' => [__('auth.invalid_token')]]);

        $patient = Patient::find($patient_auth->id);

        $validator = Validator::make($request->all(), [
            'first_name' => "required",
            'last_name' => "required",
            'phone' => "required",
        ]);
        if ($validator->fails())
            return self::errify(400, ['validator' => $validator]);

        $patient_array = [
            'first_name' => $request->input('first_name') ?: $patient->first_name,
            'last_name' => $request->input('last_name') ?: $patient->last_name,
            'phone' => $request->input('phone') ?: $patient->phone,
        ];

        $patient->update($patient_array);

        if ($patient) {
            if ($image = $request->input('image')) {
                if ($patient->image) {
                    @unlink($patient->getOriginal('image'));
                }
                $path = 'uploads/patients/patient_' . $patient->id . '/';
                $image_new_name = time() . '_' . $image->getClientOriginalName();
                $image->move($path, $image_new_name);
                $patient->image = $path . $image_new_name;
                $patient->save();
            }

            $patient = Fractal::item($patient)
                ->transformWith(new PatientTransformer($this->lang, [
                    'id', 'first_name', 'last_name', 'email', 'phone', 'image'
                ]))
                ->withResourceName('')
                ->parseIncludes([])->toArray();

            return response()->json($patient);
        } else {
            return response()->json(['error' => 'Can not update profile, please try again!']);
        }
    }

    /**
     * Change patient language
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function changeLanguage(Request $request): JsonResponse
    {
        $patient_auth = PatientAuth::patient();
        if (!$patient_auth) {
            if ($this->lang == 'ar') {
                $account_not_found_msg = 'الرمز غير صحيح او منتهى';
            } else {
                $account_not_found_msg = 'Invalid or expired token';
            }
            return response()->json(['error' => [$account_not_found_msg]]);
        }

        $patient = Patient::find($patient_auth->id);

        $validator = Validator::make($request->all(), [
            'lang' => "required|in:en,ar",
        ]);
        if ($validator->fails())
            return self::errify(400, ['validator' => $validator]);

        $lang = $request->input('lang');

        $saved = $patient->update(['lang' => $lang]);

        if ($saved) {
            return response()->json(['msg' => 'ok']);
        } else {
            return response()->json(['error' => 'Can not update language, please try again!']);
        }
    }

}
