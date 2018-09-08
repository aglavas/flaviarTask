<?php

namespace App\Services;

use PhpOffice\PhpSpreadsheet\Reader\Xls;

class XlsParser
{
    /**
     * Parser property
     *
     * @var Xls
     */
    private $parser;

    /**
     * XlsParser constructor.
     * @param Xls $xls
     */
    public function __construct(Xls $xls)
    {
        $this->parser = $xls;
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

        foreach ($importedArray as $key => $value)
        {
            if($key != 0 && !in_array(null, $value))
            {
                $formattedArray[] = [
                    'product_id' => $value[0],
                    'name' => $value[1],
                    'volume' => $value[2],
                    'abv' => $value[3],
                ];
            }
        }

        return $formattedArray;
    }

}