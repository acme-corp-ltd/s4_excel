<?php


namespace App\Utils;


use Box\Spout\Common\Entity\Cell;
use Box\Spout\Common\Entity\Row;
use Box\Spout\Common\Exception\IOException;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Box\Spout\Reader\Exception\ReaderNotOpenedException;
use Box\Spout\Reader\XLSX\Reader;
use Box\Spout\Reader\XLSX\Sheet;

class ExcelDataExtractor implements DataExtractorInterface
{

    private static function getActiveSheet(Reader $reader): Sheet {
        try {
            $sheetIterator = $reader->getSheetIterator();
        } catch (ReaderNotOpenedException $e) {
            throw new DataExtractorException();
        }

        foreach ($sheetIterator as $sheet) {
            if($sheet->isActive()) {
                return $sheet;
            }
        }

        throw new DataExtractorException();
    }

    private static function getCellValues(Row $row): array {
        $cells = $row->getCells();
        return array_map(function(Cell $cell){
            return $cell->getValue();
        }, $cells);
    }

    private static function structureData(array $rawData): array {
        $headline = array_shift($rawData);
        return array_map(function ($item) use ($headline) {
            return array_combine($headline, $item);
        }, $rawData);
    }

    public function extract(string $path): array
    {
        $reader = ReaderEntityFactory::createXLSXReader();

        try {
            $reader->open($path);
        } catch (IOException $e) {
            throw new DataExtractorException();
        }

        $sheet = static::getActiveSheet($reader);
        $excelData = [];

        foreach ($sheet->getRowIterator() as $row) {
            $excelData[] = static::getCellValues($row);
        }

        return static::structureData($excelData);
    }
}