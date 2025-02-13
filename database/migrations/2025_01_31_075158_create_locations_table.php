<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('continent_id')->nullable()->constrained('locations');
            $table->foreignId('country_id')->nullable()->constrained('locations');
            $table->foreignId('province_id')->nullable()->constrained('locations');
            $table->char('iso_code', 3)->nullable()->index();
            $table->enum('type', ['continent', 'country', 'region', 'province', 'city'])->index();
            $table->string('native_name', 128)->nullable();
            $table->string('english_name', 128);
            $table->string('timezone', 32)->nullable();
            $table->boolean('is_capital')->default(false);
            $table->integer('priority')->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        // Add spatial columns
        \Illuminate\Support\Facades\DB::statement('ALTER TABLE locations ADD COLUMN center POINT NULL after is_capital');
        \Illuminate\Support\Facades\DB::statement('ALTER TABLE locations ADD COLUMN area MULTIPOLYGON NULL after center');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
