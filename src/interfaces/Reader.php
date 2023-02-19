<?php

namespace Sooky\DatabaseImport\interfaces;
interface Reader
{
    public function read(string $filePath);
}