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
            $table->string('work_name_th')->nullable(true)->comment('ชื่องาน (ไทย)');
            $table->string('work_name_en')->nullable(true)->comment('ชื่องาน (อังกฤษ)');
            $table->string('work_office_th')->nullable(true)->comment('ชื่อบริษัท / หน่วยงาน (ไทย)');
            $table->string('work_office_en')->nullable(true)->comment('ชื่อบริษัท / หน่วยงาน (อังกฤษ)');
            $table->string('work_desc_th')->nullable(true)->comment('อธิบายงาน (ไทย)');
            $table->string('work_desc_en')->nullable(true)->comment('อธิบายงาน (อังกฤษ)');
            $table->date('work_start_date')->nullable(false)->comment('วันที่เริ่มงาน');
            $table->date('work_end_date')->nullable(true)->comment('วันที่ออกจากงาน');
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
