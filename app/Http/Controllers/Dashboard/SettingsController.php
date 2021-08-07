<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;

class SettingsController extends BaseController
{
    function __construct()
    {
        parent::__construct();
        $this->middleware('permission:setting-list', ['only' => ['index', 'list']]);
        $this->middleware('permission:setting-edit', ['only' => ['edit', 'update']]);
    }

    public function index()
    {
        return view('dashboard.settings.index');
    }

    public function list(Request $request)
    {
        $settings = Setting::query()
            ->where('key', '!=', 'FCM_SERVER_KEY')
            ->where('key', '!=', 'FCM_SENDER_ID');
        if ($request->key) {
            $settings = $settings->where('key', 'like', '%' . $request->key . '%');
        }
        if ($request->value) {
            $settings = $settings->where('value', 'like', '%' . $request->value . '%');
        }
        return datatables()->of($settings)->toJson();
    }

    public function edit($id)
    {
        $setting = Setting::find($id);
        return view('dashboard.settings.edit')->with(['setting' => $setting]);
    }

    public function update($id, Request $request)
    {
        $validator_array = [
            'key' => 'required',
            'value' => 'required',
        ];
        $validator = Validator::make($request->all(), $validator_array);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['status' => 'fail', 'error_message' => 'validation error', 'errors' => $validator->errors()]);
            } else {
                return redirect()->back()->withInput($request->all())->withErrors($validator);
            }
        }

        $updated_setting = Setting::query()->find($id);
        if ($updated_setting->type == 'file' && $file = $request->value) {
            if ($updated_setting->value) {
                @unlink($updated_setting->getOriginal('value'));
            }
            $path = 'uploads/settings/setting_' . $updated_setting->id . '/';
            $file_new_name = time() . '_' . $file->getClientOriginalName();
            $file->move($path, $file_new_name);
            $updated_setting->value = $path . $file_new_name;
        } else {
            $updated_setting->value = $request->value;
        }
        $updated_setting->description = $request->description;
        $updated_setting->save();

        if ($updated_setting) {
            session()->flash('success_message', trans('main.updated_alert_message', ['attribute' => Lang::get('setting.attribute_name')]));
            return redirect()->to(route('setting.index'));
        } else {
            session()->flash('error_message', 'Something went wrong');
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }


    }

}
