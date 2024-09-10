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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->text('sourcetype')->default('manual');
            $table->text('sourcename')->default('manual');
        });

        // Add the VECTOR column for embedding
        DB::statement('ALTER TABLE documents ADD COLUMN embedding VECTOR(3072)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn('id');
            $table->dropColumn('embedding');
            $table->dropColumn('sourcetype');
            $table->dropColumn('sourcename');
            $table->dropColumn('content');
        });
    }
};
