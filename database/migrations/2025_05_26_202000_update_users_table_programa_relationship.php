<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Step 1: Add the new column as nullable
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('programa_id')->nullable()->after('programa_academico')->constrained('programas_academicos');
        });

        // Step 2: Migrate the data
        DB::statement('UPDATE users u JOIN programas_academicos p ON u.programa_academico = p.nombre SET u.programa_id = p.id');

        // Step 3: Make the column required for students and drop the old column
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('programa_id')->nullable(false)->change();
            $table->dropColumn('programa_academico');
        });
    }

    public function down(): void
    {
        // Step 1: Add back the old column
        Schema::table('users', function (Blueprint $table) {
            $table->string('programa_academico')->after('programa_id');
        });

        // Step 2: Migrate the data back
        DB::statement('UPDATE users u JOIN programas_academicos p ON u.programa_id = p.id SET u.programa_academico = p.nombre');

        // Step 3: Drop the foreign key and column
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['programa_id']);
            $table->dropColumn('programa_id');
        });
    }
}; 