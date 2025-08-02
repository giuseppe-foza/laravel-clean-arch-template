<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $sql = 'database/migrations/sql/2025_08_02_220416_criar-estrutura-base.sql';
        DB::unprepared(file_get_contents($sql));
    }

    public function down(): void
    {
        //
    }
};
