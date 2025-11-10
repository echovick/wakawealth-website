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
        Schema::table('post_types', function (Blueprint $table) {
            $table->renameColumn('name', 'title');
        });

        Schema::table('post_types', function (Blueprint $table) {
            $table->text('description')->nullable()->after('slug');
            $table->boolean('active')->default(true)->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('post_types', function (Blueprint $table) {
            $table->dropColumn(['description', 'active']);
        });

        Schema::table('post_types', function (Blueprint $table) {
            $table->renameColumn('title', 'name');
        });
    }
};
