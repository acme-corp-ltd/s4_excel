<?php


namespace App\Utils;


interface DataExtractorInterface
{
    public function extract(string $path): array;
}
