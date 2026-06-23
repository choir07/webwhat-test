<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ImportExistingData extends Migration
{
    public function up()
    {
        // Read SQL file and execute
        $sql = file_get_contents(database_path('dump.sql'));
        DB::unprepared($sql);
    }
}