<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ProfileTEducation extends Migration
{
    private $table_name = "profile_t_education";
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->string('profile_id' , 5)->nullable(false)->comment('รหัสผู้ใช้งาน');
            $table->string('learning_list_id' , 5)->nullable(false)->comment('รหัสระดับการศึกษา');
            $table->date('efft_date')->nullable(false)->comment('วันที่ศึกษา');
            $table->date('exp_date')->nullable(true)->comment('วันที่สิ้นสุด');
            $table->string('college_name_th')->nullable(false)->comment('ชื่อสถานศึกษา (ไทย)');
            $table->string('college_name_en')->nullable(false)->comment('ชื่อสถานศึกษา (อังกฤษ)');
            $table->string('faculty')->nullable(false)->comment('คณะที่เรียน');
            $table->string('gpa')->nullable(false)->comment('เกรดเฉลี่ย');
            $table->dateTime('last_upd_date')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('วันที่แก้ไขข้อมูลล่าสุด');
            $table->string('upd_user_id', 5)->nullable(false)->comment('ผู้แก้ไขข้อมูล');
        });

        DB::statement(
            "ALTER TABLE " . $this->table_name . "
            ADD PRIMARY KEY (`profile_id` , `learning_list_id` , `efft_date`) ,
            ADD CONSTRAINT `FK_profile_edu_1` FOREIGN KEY (`profile_id`) REFERENCES `profile_t_master` (`profile_id`),
            ADD CONSTRAINT `FK_profile_edu_2` FOREIGN KEY (`learning_list_id`) REFERENCES `profile_t_learning_list` (`learning_list_id`);"
        );
    }

    public function down()
    {
        Schema::dropIfExists($this->table_name);
    }
}
