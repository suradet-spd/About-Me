<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class insert_system_data extends Seeder
{
    public function run()
    {
        DB::unprepared(File::get(public_path('data/system-data.sql')));
    }
}
