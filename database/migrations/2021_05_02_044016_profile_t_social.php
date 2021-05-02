<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ProfileTSocial extends Migration
{
    private $table_name = "profile_t_social";
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->string('profile_id' , 5)->nullable(false)->comment('รหัสผู้ใช้งาน');
            $table->string('social_list_id' , 5)->nullable(false)->comment('รหัสรายการบัญชีโซเชี่ยล');
            $table->string('social_account_link')->default('#')->comment('ลิงค์บัญชีโซเชี่ยล');
            $table->dateTime('last_upd_date')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('วันที่แก้ไขข้อมูลล่าสุด');
            $table->string('upd_user_id', 5)->nullable(false)->comment('ผู้แก้ไขข้อมูล');
        });

        DB::statement(
            "ALTER TABLE " . $this->table_name . "
            ADD PRIMARY KEY (`profile_id` , `social_list_id`) ,
            ADD CONSTRAINT `FK_profile_social_1` FOREIGN KEY (`profile_id`) REFERENCES `profile_t_master` (`profile_id`),
            ADD CONSTRAINT `FK_profile_social_2` FOREIGN KEY (`social_list_id`) REFERENCES `profile_t_social_list` (`social_list_id`);"
        );
    }

    public function down()
    {
        Schema::dropIfExists($this->table_name);
    }
}
