<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ProfileTSkill extends Migration
{
    public $table_name = 'profile_t_skill';
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->string('profile_id' , 5)->comment('รหัสผู้ใช้งาน');
            $table->integer('seq')->comment('ลำดับที่');
            $table->string('skill_desc')->comment('อธิบายความสามารถ');
            $table->string('color_code' , 10)->default('#FFFFFF')->comment('รหัสสี');
            $table->string('upd_user_id' , 5)->comment('ผู้แก้ไขข้อมูลล่าสุด');
            $table->dateTime('last_upd_date')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('วันที่แก้ไขข้อมูลล่าสุด');
        });

        DB::statement(
            " ALTER TABLE " . $this->table_name . "
            ADD PRIMARY KEY (`profile_id`,`seq`),
            ADD CONSTRAINT `FK_skill_01` FOREIGN KEY (`profile_id`) REFERENCES `profile_t_login` (`id`); "
        );
    }

    public function down()
    {
        Schema::dropIfExists($this->table_name);
    }
}
