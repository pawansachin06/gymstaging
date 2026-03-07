<?php

namespace App\Console\Commands;

use App\Models\LocationBoostCity;
use Illuminate\Console\Command;

class CreateTables extends Command
{
    protected $signature = 'app:create-tables';

    protected $description = 'Create tables without migration files';

    public function handle()
    {
        $msgs = [];

        $msgs[] = LocationBoostCity::createTable();

        foreach ($msgs as $msg) {
            if (is_string($msg) && !empty($msg)) {
                echo $msg . PHP_EOL;
            } elseif (is_array($msg)) {
                foreach ($msg as $value) {
                    if (is_string($value) && !empty($value)) {
                        echo $value . PHP_EOL;
                    }
                }
            }
        }
    }
}
