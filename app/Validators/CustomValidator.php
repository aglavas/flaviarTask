<?php

namespace App\Validators;

use Illuminate\Http\UploadedFile;

class CustomValidator
{
    /**
     * Excel extension const
     */
    const XLS = 'xls';

    /**
     * Validation rule for checking xls extension
     *
     * @param $attribute
     * @param $value
     * @param $parameters
     * @param $validator
     * @return bool
     */
    public function extensionExcel($attribute, $value, $parameters, $validator)
    {
        /** @var UploadedFile $value */
        $result = $value->getClientOriginalExtension();

        if ($result === self::XLS) {
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
