<?php

namespace Database\Seeders;

use Closure;

trait CsvReader
{
    /**
     * Opens csv file by given path and calls a
     * closure for each line of it.
     *
     * @param string $path
     * @param Closure $lineClosure
     * @param string $delimiter
     *
     * @return void
     */
    public function readCsv(string $path, Closure $lineClosure, string $delimiter = ','): void
    {
        $handle = fopen($path, 'r');
        $lineClosure($first = fgetcsv($handle, 0, $delimiter), false);

        while (!feof($handle)) {
            $lineClosure($line = fgetcsv($handle, 0, $delimiter), $first);
        }
    }
}
