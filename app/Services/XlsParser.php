<?php

namespace App\Services;

use PhpOffice\PhpSpreadsheet\Reader\Xls;
use Illuminate\Validation\Factory as IlluminateValidator;

class XlsParser
{
    /**
     * Parser property
     *
     * @var Xls
     */
    private $parser;

    /**
     * @var IlluminateValidator
     */
    private $validator;

    /**
     * Validation rules
     *
     * @var array
     */
    private $rules = [
        'product_id' => ['required', 'unique:mysql.products,product_id'],
        'name' => ['required'],
        'volume' => ['integer', 'min:1'],
        'abv' => ['numeric', 'min:1'],
    ];

    /**
     * XlsParser constructor.
     * @param Xls $xls
     */
    public function __construct(Xls $xls, IlluminateValidator $factory)
    {
        $this->parser = $xls;
        $this->validator = $factory;
    }

    /**
     * Parse Xls file and format it
     *
     * @param $file
     * @return array
     */
    public function parse($file)
    {
        $spreadSheet = $this->parser->load($file);
        $importedArray = $spreadSheet->getActiveSheet()->toArray();

        $formattedArray = [];

        foreach ($importedArray as $key => $value) {
            if ($key != 0 && !in_array(null, $value)) {
                $row = [
                    'product_id' => $value[0],
                    'name' => $value[1],
                    'volume' => $value[2],
                    'abv' => $value[3],
                ];

                if ($this->validateRow($row)) {
                    $formattedArray[] = $row;
                }
            }
        }

        return $formattedArray;
    }


    /**
     * Validate row from Excel table
     *
     * @param array $row
     * @return bool
     */
    private function validateRow(array $row)
    {
        $validator = $this->validator->make($row, $this->rules);

        if ($validator->fails()) {
            return false;
        }

        return true;
    }
}
