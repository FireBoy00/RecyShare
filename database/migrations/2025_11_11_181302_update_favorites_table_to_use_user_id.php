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
        Schema::table('favorites', function (Blueprint $table) {
            // Drop the old unique constraint
            $table->dropUnique(['recipe_id', 'user_identifier']);
            // Drop the user_identifier column
            $table->dropColumn('user_identifier');
            // Add user_id foreign key
            $table->foreignId('user_id')->after('recipe_id')->constrained()->onDelete('cascade');
            // Add new unique constraint
            $table->unique(['recipe_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('favorites', function (Blueprint $table) {
            // Drop the new unique constraint
            $table->dropUnique(['recipe_id', 'user_id']);
            // Drop user_id foreign key
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            // Add back user_identifier
            $table->string('user_identifier')->after('recipe_id');
            // Add back old unique constraint
            $table->unique(['recipe_id', 'user_identifier']);
        });
    }
};
