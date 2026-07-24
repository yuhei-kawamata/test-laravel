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
        Schema::table('users', function (Blueprint $table) {

            // usersテーブルに直接追加して、migrate:freshを実行してもよい
            // 開発序盤でデータベースにデータが無く、migrate:freshを実行しても問題ないため。
            $table->enum('role', ['user', 'admin'])->default('user')->after('password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
