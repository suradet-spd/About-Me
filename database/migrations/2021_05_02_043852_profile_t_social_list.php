<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ProfileTSocialList extends Migration
{
    private $table_name = "profile_t_social_list";
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->string('social_list_id' , 5)->primary()->comment('รหัสรายการบัญชีโซเชี่ยล');
            $table->string('social_list_name')->nullable(false)->comment('ชื่อรายการบัญชีโซเชี่ยล');
            $table->string('social_list_icon_name')->nullable(false)->comment('ชื่อสัญลักษณ์บัญชีโซเชี่ยล');
            $table->string('active_flag' , 1)->default('Y')->comment('สถานะการใช้งาน');
            /*
                Y = Active
                N = Non Active
            */
            $table->dateTime('last_upd_date')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('วันที่แก้ไขข้อมูลล่าสุด');
            $table->string('upd_user_id', 5)->nullable(false)->comment('ผู้แก้ไขข้อมูล');
        });
    }

    public function down()
    {
        Schema::dropIfExists($this->table_name);
    }
}
