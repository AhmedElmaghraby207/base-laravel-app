<?php

namespace App\Http\Controllers\Dashboard;

use App\Repositories\NotificationTemplates\NotificationTemplatesRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;

class NotificationTemplatesController extends BaseController
{
    protected $templateRep;

    public function __construct(NotificationTemplatesRepositoryInterface $templateRep)
    {
        parent::__construct();
        $this->templateRep = $templateRep;
        $this->middleware('permission:notification_template-list', ['only' => ['index', 'list']]);
        $this->middleware('permission:notification_template-edit', ['only' => ['edit', 'update']]);
    }

    public function index()
    {
        return view('dashboard.notificationTemplates.index');
    }

    public function list(Request $request)
    {
        $name = $request->name;
        $subject = $request->subject;
        return datatables()->of($this->templateRep->list(false, ['name' => $name, 'subject' => $subject]))->toJson();
    }

    public function edit($id)
    {
        $notification_template = $this->templateRep->get($id);
        return view('dashboard.notificationTemplates.edit')->with(['notification_template' => $notification_template]);
    }

    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject_en' => 'required',
            'subject_ar' => 'required',
            'template_en' => 'required',
            'template_ar' => 'required',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['status' => 'fail', 'error_message' => 'validation error', 'errors' => $validator->errors()]);
            } else {
                return redirect()->back()->withInput($request->all())->withErrors($validator);
            }
        }

        $template_array = [
            'subject_en' => $request->subject_en,
            'subject_ar' => $request->subject_ar,
            'template_en' => $request->template_en,
            'template_ar' => $request->template_ar,
            'is_popup' => $request->is_popup,
        ];

        if ($request->is_popup) {
            $template_array['is_popup'] = $request->is_popup;
        } else {
            $template_array['is_popup'] = 0;
        }

        $updated_template = $this->templateRep->update($id, $template_array);
        if ($updated_template) {
            if ($popup_image = $request->popup_image) {
                $path = 'uploads/notificationTemplates/';
                $image_new_name = time() . '_' . $popup_image->getClientOriginalName();
                $popup_image->move($path, $image_new_name);
                $updated_template->popup_image = $path . $image_new_name;

                $updated_template->save();
            }
            session()->flash('success_message', trans('main.updated_alert_message', ['attribute' => Lang::get('notification_template.attribute_name')]));
            return redirect()->route('notification_template.index');
        } else {
            session()->flash('error_message', 'Something went wrong');
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }
    }
}
