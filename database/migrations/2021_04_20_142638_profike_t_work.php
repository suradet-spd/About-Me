<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ProfikeTWork extends Migration
{
    public $table_name = 'profile_t_work';
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->string('profile_id' , 5)->comment('รหัสผู้ใช้งาน');
            $table->integer('work_seq')->comment('ลำดับงาน');
            $table->dateTime('work_start_date')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('วันที่เริ่มงาน');
            $table->dateTime('work_end_date')->default(null)->comment('วันที่สิ้นสุดงาน');
            $table->string('work_position')->comment('ตำแหน่งงาน');
            $table->string('work_office')->comment('สถานที่ทำงาน');
            $table->string('upd_user_id')->comment('ผู้แก้ไขข้อมูลล่าสุด');
            $table->dateTime('upd_user_id')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('วันที่แก้ไขข้อมูลล่าสุด');
        });

        DB::statement(
            " ALTER TABLE " . $this->table_name . "
            ADD PRIMARY KEY (`profile_id`,`work_seq`,`work_start_date`),
            ADD CONSTRAINT `FK_work_01` FOREIGN KEY (`profile_id`) REFERENCES `profile_t_master` (`profile_id`); "
        );
    }

    public function down()
    {
        Schema::dropIfExists($this->table_name);
    }
}
