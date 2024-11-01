<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('grupos', function(Blueprint $table)
        {
            $table->id();               
            $table->string('nombre_grupo', 100);
            $table->string('materia',100);
            $table->date('fecha_clase');    
            $table->string('profesor',100);
            $table->time('horario_clase');
            $table->time('horario_clase_final');
            $table->time('horario_registro');
            $table->string('qr_code', 255);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP TABLE IF EXISTS grupos CASCADE');
    }
};
