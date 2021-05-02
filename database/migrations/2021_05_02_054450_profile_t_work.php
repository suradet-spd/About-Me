<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ProfileTWork extends Migration
{
    private $table_name = "profile_t_work";
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->string('profile_id' , 5)->nullable(false)->comment('รหัสผู้ใช้งาน');
            $table->integer('work_seq')->nullable(false)->comment('ลำดับงาน');
            $table->string('work_name_th')->nullable(false)->comment('ชื่องาน (ไทย)');
            $table->string('work_name_en')->nullable(false)->comment('ชื่องาน (อังกฤษ)');
            $table->string('work_office_th')->nullable(false)->comment('ชื่อบริษัท / หน่วยงาน (ไทย)');
            $table->string('work_office_en')->nullable(false)->comment('ชื่อบริษัท / หน่วยงาน (อังกฤษ)');
            $table->string('work_desc_th')->nullable(false)->comment('อธิบายงาน (ไทย)');
            $table->string('work_desc_en')->nullable(false)->comment('อธิบายงาน (อังกฤษ)');
            $table->string('work_start_year' , 4)->nullable(false)->comment('ปีที่เริ่มงาน');
            $table->string('work_end_year' , 4)->nullable(true)->default(null)->comment('ปีที่ออกจากงาน');
            $table->dateTime('last_upd_date')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('วันที่แก้ไขข้อมูลล่าสุด');
            $table->string('upd_user_id', 5)->nullable(false)->comment('ผู้แก้ไขข้อมูล');
        });

        DB::statement(
            "ALTER TABLE " . $this->table_name . "
            ADD PRIMARY KEY (`profile_id` , `work_seq`) ,
            ADD CONSTRAINT `FK_profile_work` FOREIGN KEY (`profile_id`) REFERENCES `profile_t_master` (`profile_id`);"
        );
    }

    public function down()
    {
        Schema::dropIfExists($this->table_name);
    }
}
