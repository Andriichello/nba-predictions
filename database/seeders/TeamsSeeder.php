<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Symfony\Component\Console\Output\ConsoleOutput;

class TeamsSeeder extends Seeder
{
    use CsvReader;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $columns = [];
        $fillable = (new Team())->getFillable();

        $this->readCsv(
            resource_path('/csvs/teams.csv'),
            function (array|false $line, array|false $firstLine) use (&$columns, $fillable) {
                if ($line === false) {
                    return;
                }

                if ($firstLine === false) {
                    $columns = array_map(fn($str) => strtolower($str), $line);
                    return;
                }

                $attributes = [];
                for ($i = 0; $i < min(count($columns), count($line)); $i++) {
                    if (in_array($columns[$i], $fillable)) {
                        $attributes[$columns[$i]] = $line[$i];
                    }
                }

                Team::query()->create($attributes);
            }
        );
    }
}
