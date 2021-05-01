<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ProfileTEducation extends Migration
{
    public $table_name = 'profile_t_education';
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->string('profile_id' , 5)->comment('รหัสผู้ใช้งาน');
            $table->integer('edu_seq')->comment('ลำดับการศึกษา');
            $table->dateTime('edu_start_date')->comment('วันที่เริ้่มศึกษา');
            $table->dateTime('edu_end_date')->comment('วันที่สิ้นสุดการศึกษา');
            $table->string('edu_faculty')->comment('ชื่อคณะที่ศึกษา');
            $table->string('edu_college')->comment('ชื่อสถานศึกษา');
            $table->string('upd_user_id')->comment('ผู้แก้ไขข้อมูลล่าสุด');
            $table->dateTime('last_upd_date')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('วันที่แก้ไขข้อมูลล่าสุด');
        });

        DB::statement(
            " ALTER TABLE " . $this->table_name . "
            ADD PRIMARY KEY (`profile_id`,`edu_seq`,`edu_start_date`),
            ADD CONSTRAINT `FK_education_01` FOREIGN KEY (`profile_id`) REFERENCES `profile_t_login` (`id`); "
        );
    }

    public function down()
    {
        Schema::dropIfExists($this->table_name);
    }
}
