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
        Schema::table('comments', function (Blueprint $table) {
            // Drop the author_name column
            $table->dropColumn('author_name');
            // Add user_id foreign key
            $table->foreignId('user_id')->after('recipe_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            // Drop user_id foreign key
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            // Add back author_name
            $table->string('author_name')->after('recipe_id');
        });
    }
};
