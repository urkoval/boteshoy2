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
        Schema::table('contenido_juegos', function (Blueprint $table) {
            $table->text('head_extra')->nullable()->after('contenido_markdown');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contenido_juegos', function (Blueprint $table) {
            $table->dropColumn('head_extra');
        });
    }
};
