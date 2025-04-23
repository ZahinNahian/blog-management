<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\table;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('remember_token');
            $table->renameColumn('name', 'username');
            $table->unique('username');
            $table->string('profile_pic')->nullable()->default('uploads/avatar.png')->after('password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->rememberToken()->after('password');
            $table->dropUnique(['username']);
            $table->renameColumn('username', 'name');
            $table->dropColumn('profile_pic');
        });
    }
};
