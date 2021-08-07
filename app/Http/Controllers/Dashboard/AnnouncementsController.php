<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Announcement;
use App\Mail\PatientAnnouncement;
use App\Notifications\P_Announcement;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AnnouncementsController extends BaseController
{

    function __construct(Request $request)
    {
        parent::__construct();
        $this->middleware('permission:announcement-create', ['only' => ['create', 'send']]);
    }

    public function create(Request $request)
    {
        $patients = Patient::all();
        return view('dashboard.announcements.create')->with(['patients' => $patients]);
    }

    public function send(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "patients" => "required_if:specify_patients,==,true",
            "subject_en" => "required|min:3|max:500",
            "subject_ar" => "required|min:3|max:500",
            "message_en" => "required|min:3|max:2000",
            "message_ar" => "required|min:3|max:2000",
            "mail_checkbox" => 'required_without:notify_checkbox',
            "notify_checkbox" => 'required_without:mail_checkbox',
        ]);
        if ($validator->fails())
            return redirect()->back()->withInput($request->all())->withErrors($validator);

        if (empty($request->mail_checkbox) && empty($request->notify_checkbox))
            return redirect()->back()->with('error_message', 'You must select Method to send (Mail Or Notification)!');

        $announcement = new Announcement;
        $announcement->subject_en = $request->subject_en;
        $announcement->subject_ar = $request->subject_ar;
        $announcement->message_en = $request->message_en;
        $announcement->message_ar = $request->message_ar;

        $patients_ids_for_tokens = array();
        if ($request->patients) {
            $patients_ids = '';
            foreach ($request->patients as $key => $id) {
                $patients_ids .= '[' . $id . ']';
                $patients_ids_for_tokens[] = (int)$id;
            }
            $announcement->patients_ids = $patients_ids;
        } else
            $announcement->patients_ids = -1;

        $announcement->publish_at = date('Y-m-d H:i:s');
        $announcement->created_at = date('Y-m-d H:i:s');
        $announcement->save();

        if ($request->patients)
            $array_patients = Patient::whereIn('id', $patients_ids_for_tokens)->get();
        else
            $array_patients = Patient::get();

        if ($request->mail_checkbox) {
            foreach ($array_patients as $key => $patient) {
                try {
                    if ($patient->email_verified_at != null) {
                        $validator = validator::make(['email' => $patient->email], [
                            "email" => "email"
                        ]);
                        if (!$validator->fails()) {
                            // send Email
                            global $emailTo;
                            $emailTo = $patient->email;
                            global $emailToName;
                            $emailToName = $patient->first_name . ' ' . $patient->last_name;
                            $hash = $patient->hash;
                            $from = env('MAIL_FROM_ADDRESS');
                            Mail::to($emailTo)->send(new PatientAnnouncement($announcement, $patient, $hash, $from));
                        }
                    }
                } catch (\Exception $e) {
                    // Get error here
                }
            }
        }

        if ($request->notify_checkbox) {
            foreach ($array_patients as $patient) {
                $patient->notify(new P_Announcement($patient, $request->subject_en, $request->subject_ar, $request->message_en, $request->message_ar));
            }
        }

        return redirect()->back()->with('success_message', 'Successfully Sent!');
    }

}
