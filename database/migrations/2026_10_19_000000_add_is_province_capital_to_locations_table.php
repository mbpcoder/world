<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private string $tableName;

    public function __construct()
    {
        $this->tableName = config('world.table_name');
    }

    public function up(): void
    {
        Schema::table($this->tableName, function (Blueprint $table) {
            $table->boolean('is_province_capital')->default(false)->after('is_capital');
        });
    }

    public function down(): void
    {
        Schema::table($this->tableName, function (Blueprint $table) {
            $table->dropColumn('is_province_capital');
        });
    }
};
