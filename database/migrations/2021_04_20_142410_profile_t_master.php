<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ProfileTMaster extends Migration
{
    public $table_name = "profile_t_master";
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->string('profile_id' , 5)->primary()->comment('รหัสผู้ใช้งาน');
            $table->string('profile_name_th')->comment('ชื่อผู้ใช้งาน (ไทย)');
            $table->string('profile_name_en')->comment('ชื่อผู้ใช้งาน (อังกฤษ)');
            $table->string('about_you' , 2000)->comment('คำอธิบายตัวตน');
            $table->string('social_account' , 2000)->comment('บัญชีโซเชี่ยล');
            $table->string('upd_user_id' , 5)->comment('ผู้แก้ไขข้อมูลล่าสุด');
            $table->dateTime('last_upd_date')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('วันที่แก้ไขข้อมูลล่าสุด');
        });

        DB::statement(
            " ALTER TABLE " . $this->table_name . "
            ADD CONSTRAINT `FK_master_01` FOREIGN KEY (`profile_id`) REFERENCES `profile_t_login` (`id`); "
        );
    }

    public function down()
    {
        Schema::dropIfExists($this->table_name);
    }
}
