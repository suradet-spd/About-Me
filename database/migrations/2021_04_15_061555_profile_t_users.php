<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ProfileTUsers extends Migration
{
    public $tableName = 'profile_t_users';

    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('id' , 5)->primary();
            $table->string('name', 50);
            $table->string('email')->unique();
            $table->string('account_type', 1)->default('A');
            /*
                A = Active
                D = Delete
                S = Stop // not delete but another people can't see this
            */
            $table->string('gen_profile_flag' , 1)->default('N');
            /*
                Y = Yes (success Create)
                N = No (Non create)
            */
            $table->string('password');
            $table->rememberToken();
            $table->dateTime('create_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('last_upd_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('upd_user_id', 5)->comment('ผู้แก้ไขข้อมูล');

            $table->index(["id"], 'user_id_idx');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->tableName);
    }
}
