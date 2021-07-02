<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ProfileTSystemConfig extends Migration
{
    private $table_name = "profile_t_system_config";
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->string('config_type' , 2)->comment('ประเภทการตั้งค่า');
                /*
                    BG = Background color
                    FC = Font Color
                    BC = Button Color

                    LA = Line Account
                    MA = Mail Account

                    AN = Anouncement

                    AS = Admin website
                */
            $table->dateTime('efft_date')->comment('วันที่มีผลของการตั้งค่า');
            $table->dateTime('exp_date')->default(null)->comment('วันที่สิ้นสุดผลของการตั้งค่า');
            $table->string('config_desc' , 3000)->nullable(false)->comment('รายละเอียดการตั้งค่า');
            $table->dateTime('last_upd_date')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('วันที่แก้ไขข้อมูลล่าสุด');
            $table->string('upd_user_id', 5)->nullable(false)->comment('ผู้แก้ไขข้อมูล');
        });

        DB::statement(
            "ALTER TABLE " . $this->table_name . "
            ADD PRIMARY KEY (`config_type` , `efft_date`),
            ADD CONSTRAINT `FK_profile_sys_config` FOREIGN KEY (`upd_user_id`) REFERENCES `profile_t_master` (`profile_id`);"
        );
    }

    public function down()
    {
        Schema::dropIfExists($this->table_name);
    }
}
