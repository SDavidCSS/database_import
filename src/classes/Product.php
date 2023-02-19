<?php

namespace Sooky\DatabaseImport\classes;

class Product extends Record {
    public int $id = 0;
    public string $sku = '';
    public string $ean = '';
    public string $name = '';
    public string $shortDesc = '';
    public string $manufacturer = '';
    public string $price = '';
    public string $stock = '';

    public static function tableName(): string
    {
        return 'products';
    }

    public function attributes(): array
    {
        $attributes = ['sku', 'ean', 'name', 'shortDesc', 'manufacturer', 'price', 'stock'];
        array_unshift($attributes, self::primaryKey());
        return $attributes;
    }

    public function beforeSave()
    {
        if(!empty($this->price)) $this->price = str_replace(',', '.', $this->price);
    }

}
