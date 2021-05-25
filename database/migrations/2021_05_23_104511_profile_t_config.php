<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\Types\This;

class ProfileTConfig extends Migration
{
    private $table_name = "profile_t_config";
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->string('profile_id' , 5)->comment('รหัสผู้ใช้งาน');
            $table->string('config_type' , 2)->comment('ประเภทการตั้งค่า');
            /*
                BC = Background color
                FC = Font color
            */
            $table->dateTime('efft_date')->default(DB::raw('CURRENT_TIMESTAMP()'))->comment('วันที่มีผลของการตั้งค่า');
            $table->dateTime('exp_date')->nullable(true)->comment('วันที่สิ้นสุดการตั้งค่า');
            $table->string('config_desc' , 2000)->nullable(false)->comment('รายละเอียดการตั้งค่า');
            $table->dateTime('last_upd_date')->default(DB::raw('CURRENT_TIMESTAMP()'))->comment('วันที่แก้ไขข้อมูลล่าสุด');
            $table->string('upd_user_id')->nullable(false)->comment('ผู้แก้ไขข้อมูลล่าสุด');
        });

        DB::statement(
            "ALTER TABLE " . $this->table_name . "
            ADD PRIMARY KEY (`profile_id` , `config_type` , `efft_date`),
            ADD CONSTRAINT `FK_profile_config_1` FOREIGN KEY (`profile_id`) REFERENCES `profile_t_master` (`profile_id`);"
        );


    }

    public function down()
    {
        Schema::dropIfExists($this->table_name);
    }
}
