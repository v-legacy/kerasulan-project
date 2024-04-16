<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('predicted', function (Blueprint $table) {
            $table->id();
            $table->string('epoch');
            $table->string('x1');
            $table->string('x2');
            $table->string('v');
            $table->string('luaran_y');
            $table->string('y_target');
            $table->string('error');
            $table->string('w1_baru');
            $table->string('w2_baru');
            $table->string('delta_w1');
            $table->string('delta_w2');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('predicted');
    }
};
