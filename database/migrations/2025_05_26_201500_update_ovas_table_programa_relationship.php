<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Step 1: Add deleted_at to programas_academicos table
        Schema::table('programas_academicos', function (Blueprint $table) {
            $table->softDeletes();
        });

        // Step 2: Add the new column as nullable
        Schema::table('ovas', function (Blueprint $table) {
            $table->foreignId('programa_id')->nullable()->after('docente_id')->constrained('programas_academicos');
        });

        // Step 3: Migrate the data
        DB::statement('UPDATE ovas o JOIN programas_academicos p ON o.programa_academico = p.nombre SET o.programa_id = p.id');

        // Step 4: Make the column required and drop the old column
        Schema::table('ovas', function (Blueprint $table) {
            $table->foreignId('programa_id')->nullable(false)->change();
            $table->dropColumn('programa_academico');
        });

        Schema::table('actividades', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        // Step 1: Add back the old column
        Schema::table('ovas', function (Blueprint $table) {
            $table->string('programa_academico')->after('docente_id');
        });

        // Step 2: Migrate the data back
        DB::statement('UPDATE ovas o JOIN programas_academicos p ON o.programa_id = p.id SET o.programa_academico = p.nombre');

        // Step 3: Drop the foreign key and column
        Schema::table('ovas', function (Blueprint $table) {
            $table->dropForeign(['programa_id']);
            $table->dropColumn('programa_id');
        });

        // Step 4: Remove deleted_at from programas_academicos table
        Schema::table('programas_academicos', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('actividades', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}; 