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
        Schema::table('posts', function (Blueprint $table) {
            // Soft deletes ekle
            $table->softDeletes();

            // user_id ekle (nullable olarak başlatalım, sonra NOT NULL yapabiliriz)
            $table->foreignId('user_id')
                ->nullable()
                ->after('id')
                ->constrained('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // Foreign key'i sil
            $table->dropForeignIdFor('users');
            $table->dropColumn('user_id');

            // Soft deletes sütununu sil
            $table->dropSoftDeletes();
        });
    }
};
