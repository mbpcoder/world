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
        Schema::table('locations', function (Blueprint $table) {
            $table->foreignId('region_id')->nullable()->after('country_id')->constrained($this->tableName);
        });
    }

    public function down(): void
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->dropForeign(['region_id']);
            $table->dropColumn('region_id');
        });
    }
};
