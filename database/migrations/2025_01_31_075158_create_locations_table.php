<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \Illuminate\Support\Facades\DB;

return new class extends Migration {

    private string $tableName;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->tableName = config('world.table_name');
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->id();
            $table->foreignId('continent_id')->nullable()->constrained($this->tableName);
            $table->foreignId('country_id')->nullable()->constrained($this->tableName);
            $table->foreignId('province_id')->nullable()->constrained($this->tableName);
            $table->char('iso_code', 3)->nullable()->index();
            $table->enum('type', ['continent', 'country', 'region', 'province', 'city'])->index();
            $table->string('native_name', 128)->nullable();
            $table->string('english_name', 128)->index();
            $table->string('timezone', 32)->nullable();
            $table->boolean('is_capital')->default(false);
            $table->integer('priority')->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        // Add spatial columns
      DB::statement("ALTER TABLE $this->tableName ADD COLUMN center POINT NULL after is_capital");
      DB::statement("ALTER TABLE $this->tableName ADD COLUMN area MULTIPOLYGON NULL after center");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->tableName);
    }
};
