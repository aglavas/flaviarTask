<?php

namespace App\Validators;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class CustomValidator
{

    /**
     * Validation rule for checking xls extension
     *
     * @param $message
     * @param $attribute
     * @param $rule
     * @param $parameters
     * @return bool
     */
    public function extensionExcel($attribute, $value, $parameters, $validator)
    {
        /** @var UploadedFile $value */
        $result = $value->getClientOriginalExtension();

        if($result === 'xls')
        {
            return true;
        }

        return false;
    }

    /**
     *
     * Replacer for custom message
     *
     * @param $message
     * @param $attribute
     * @param $rule
     * @param $parameters
     * @return string
     */
    public function extensionExcelReplacer($message, $attribute, $rule, $parameters)
    {
        $message = "Key " . $attribute . " must be of extension xls.";

        return $message;
    }
}
