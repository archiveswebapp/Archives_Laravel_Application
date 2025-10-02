<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('categories', function (Blueprint $table) {
            $table->string('slug', 255)->unique()->after('name');
            $table->string('image', 255)->nullable()->after('slug');        
            $table->text('description')->nullable()->after('image');        
        });
    }

    public function down(): void {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropColumn(['slug', 'image', 'description']);
        });
    }
};
