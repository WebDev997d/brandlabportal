<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToProjectUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_user', function (Blueprint $table) {
            $table->foreign(['project_id'])->references(['id'])->on('projects')->onDelete('CASCADE');
            $table->foreign(['user_id'])->references(['id'])->on('users')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_user', function (Blueprint $table) {
            $table->dropForeign('project_user_project_id_foreign');
            $table->dropForeign('project_user_user_id_foreign');
        });
    }
}
