<?php

namespace Sooky\DatabaseImport\classes;

class Preparator
{
    public function prepare(array $data)
    {
        [$header, $rows] = $data;
        $preparedData = [];

        foreach ($rows as $row) {
            $preparedData[] = array_combine($header, $row);
        }

        return $preparedData;
    }
}