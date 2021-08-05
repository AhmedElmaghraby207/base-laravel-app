<?php

namespace App\Transformers;

use Illuminate\Support\Arr;
use League\Fractal;

class PatientTransformer extends Fractal\TransformerAbstract
{
    protected $lang;
    protected $fields;
    protected $availableIncludes = [];

    public function __construct($lang = 'en', $fields = null)
    {
        $this->lang = $lang;
        $this->fields = $fields;
    }

    public function transform($item)
    {
        $res = [
            'id' => $item['id'],
            'first_name' => $item['first_name'],
            'last_name' => $item['last_name'],
            'email' => $item['email'],
            'phone' => $item['phone'],
            'is_active' => $item['is_active'] == 1,
            'image' => $item['image'],
            'birth_date' => $item['birth_date'],
            'weight' => $item['weight'],
            'height' => $item['height'],
            'address' => $item['address'],
            'facebook_id' => $item['facebook_id'],
            'google_id' => $item['google_id'],
            'apple_id' => $item['apple_id'],
            'mobile_os' => $item['mobile_os'],
            'mobile_model' => $item['mobile_model'],
            'created_at' => $item['created_at'],
            'token' => $item['token'],
            'lang' => $item['lang'],
        ];
        if ($this->lang == 'en') {
            $res['gender'] = $item['gender'] == 1 ? "Male" : "Female";
        } else if ($this->lang == 'ar') {
            $res['gender'] = $item['gender'] == 1 ? "مذكر" : "مئنث";
        }

        if ($this->fields != null) {
            return Arr::only($res, $this->fields);
        }
        return $res;
    }
}
