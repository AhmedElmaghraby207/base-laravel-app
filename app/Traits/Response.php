<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Config;

trait Response
{
    public static function errify($code, $errors = NULL)
    {
        $customErrors = [];

        if ($errors) {
            $validator = array_key_exists('validator', $errors) ? $errors['validator'] : NULL;

            if ($validator) {
                $validationErrors = $validator->errors()->toArray();
                $failedFields = $validator->failed();

                foreach ($validationErrors as $field => $fieldErrors) {

                    for ($i = 0; $i < count($fieldErrors); $i++) {
                        $_code = Config::get('errify.' . strtolower(array_keys($failedFields[$field])[0]));
                        if ($_code == null) {
                            $_code = 1;
                        }
                        $customError = [
                            'message' => $fieldErrors[$i],
//                            'code' => $_code
                        ];

                        $customErrors[] = $customError;
                    }
                }
            }

            $otherErrors = array_key_exists('errors', $errors) ? $errors['errors'] : NULL;

            if ($otherErrors) {

                foreach ($otherErrors as $error) {
                    $_code = Config::get('errify.' . $error);
                    if ($_code == null) {
                        $_code = 1;
                    }
                    $customError = [
                        'message' => trans($error),
//                        'code' => $_code
                    ];

                    $customErrors[] = $customError;
                }
            }
        }

        return new JsonResponse(['errors' => $customErrors], $code);
    }

}
