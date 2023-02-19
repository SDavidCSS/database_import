<?php

namespace Sooky\DatabaseImport\classes;

use Sooky\DatabaseImport\interfaces\Reader;

class CsvReader implements Reader
{
    public function read(string $filePath)
    {
        echo 'I am reading mkay' . PHP_EOL;

        if (($handle = fopen($filePath, "r"))) {
            while (($data = fgetcsv($handle, 1000, ";"))) {
                $result[] = $data;
            }
            fclose($handle);
        }

        return [array_shift($result), $result];
    }
}