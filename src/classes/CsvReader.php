<?php

namespace Sooky\DatabaseImport\classes;

use Sooky\DatabaseImport\interfaces\Reader;

class CsvReader implements Reader
{
    public function read(string $filePath): array
    {
        if (($handle = fopen($filePath, "r"))) {
            while (($data = fgetcsv($handle, 1000, ";"))) {
                $result[] = $data;
            }
            fclose($handle);
        }

        return [array_shift($result), $result];
    }
}