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
        Schema::create('recruitment', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_user')->unsigned();
            $table->string('nik', 60);
            $table->string('nama_lengkap', 60);
            $table->string('pekerjaan', 60);
            $table->string('alamat', 60);
            $table->string('telp', 60);
            $table->string('umur', 60);
            $table->string('pendidikan', 60);
            $table->string('email', 60);
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recruitment');
    }
};
