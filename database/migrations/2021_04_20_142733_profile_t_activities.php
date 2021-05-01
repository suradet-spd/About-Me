<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ProfileTActivities extends Migration
{
    public $table_name = 'profile_t_activities';
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->string('profile_id' , 5)->comment('รหัสผู้ใช้งาน');
            $table->integer('activities_seq')->comment('ลำดับกิจกรรม');
            $table->string('activities_caption',500)->comment('คำอธิบายกิจกรรม');
            $table->string('activities_image', 2000)->comment('ชื่อภาพกิจกรรม');
            $table->string('upd_user_id' , 5)->comment('ผู้แก้ไขข้อมูลล่าสุด');
            $table->dateTime('last_upd_date')->comment('วันที่แก้ไขข้อมูลล่าสุด');
        });

        DB::statement(
            " ALTER TABLE " . $this->table_name . "
            ADD PRIMARY KEY (`profile_id`,`activities_seq`),
            ADD CONSTRAINT `FK_activities_01` FOREIGN KEY (`profile_id`) REFERENCES `profile_t_login` (`id`); "
        );
    }

    public function down()
    {
        Schema::dropIfExists($this->table_name);
    }
}
