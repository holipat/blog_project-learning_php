<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * This migration adds database indexes to improve query performance
     * for frequently accessed fields.
     */
    public function up(): void
    {
        // Add indexes to posts table
        Schema::table('posts', function (Blueprint $table) {
            // Index for user relationship queries
            $table->index('user_id', 'idx_posts_user_id');
            
            // Index for sorting by creation date (used in index queries)
            $table->index('created_at', 'idx_posts_created_at');
            
            // Index for soft delete queries
            $table->index('deleted_at', 'idx_posts_deleted_at');
            
            // Composite index for common query pattern (user + created_at)
            $table->index(['user_id', 'created_at'], 'idx_posts_user_created');
            
            // Index for title search/filter
            $table->index('title', 'idx_posts_title');
        });
        
        // Add index to users table for theme preference lookups
        Schema::table('users', function (Blueprint $table) {
            $table->index('theme_preference', 'idx_users_theme_preference');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove indexes from posts table
        Schema::table('posts', function (Blueprint $table) {
            $table->dropIndex('idx_posts_user_id');
            $table->dropIndex('idx_posts_created_at');
            $table->dropIndex('idx_posts_deleted_at');
            $table->dropIndex('idx_posts_user_created');
            $table->dropIndex('idx_posts_title');
        });
        
        // Remove index from users table
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('idx_users_theme_preference');
        });
    }
};

