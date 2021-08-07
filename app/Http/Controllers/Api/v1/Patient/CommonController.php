<?php

namespace App\Http\Controllers\Api\v1\Patient;

use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommonController extends PatientApiController
{
    protected $lang;

    function __construct(Request $request)
    {
        parent::__construct();
        $this->lang = $request->header('x-lang-code');
    }

    /**
     * Get terms & privacy
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function termsAndPrivacy(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            "type" => "required|in:0,1"
        ]);
        if ($validator->fails())
            return self::errify(400, ['validator' => $validator]);

        if ($request->input('type') == 0) {

            if ($this->lang == 'en') {
                $policies = Setting::query()->where('key', 'english_privacy_policies')->first();
            } elseif ($this->lang == 'ar') {
                $policies = Setting::query()->where('key', 'arabic_privacy_policies')->first();
            } else {
                $policies = null;
            }
            if ($policies) {
                return response()->json(['data' => $policies->value]);
            } else {
                return response()->json(['error' => 'Not found']);
            }

        } elseif ($request->input('type') == 1) {

            if ($this->lang == 'en') {
                $terms = Setting::query()->where('key', 'english_terms_and_conditions')->first();
            } elseif ($this->lang == 'ar') {
                $terms = Setting::query()->where('key', 'arabic_terms_and_conditions')->first();
            } else {
                $terms = null;
            }
            if ($terms) {
                return response()->json(['data' => $terms->value]);
            } else {
                return response()->json(['error' => 'Not found']);
            }

        } else {
            return response()->json(['error' => 'Invalid type']);
        }

    }
}
