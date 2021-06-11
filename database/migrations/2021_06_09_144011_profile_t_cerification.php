<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ProfileTCerification extends Migration
{
    private $table_name = "profile_t_certificate";
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->string('profile_id' , 5)->comment('รหัสผู้ใช้งาน');
            $table->integer('cert_seq')->comment('ลำดับใบประกาศ');
            $table->string('cert_name_th')->nullable(true)->comment('ชื่อใบประกาศ (ไทย)');
            $table->string('cert_name_en')->nullable(true)->comment('ชื่อใบประกาศ (อังกฤษ)');
            $table->string('cert_desc_th' , 500)->nullable(true)->comment('อธิบายใบประกาศ (ไทย)');
            $table->string('cert_desc_en' , 500)->nullable(true)->comment('อธิบายใบประกาศ (อังกฤษ)');
            $table->date('cert_get_date')->nullable(false)->comment('วันที่ได้รับใบประกาศ');
            $table->string('cert_images' , 500)->nullable(false)->comment('รูปภาพใบประกาศ');
            $table->dateTime('last_upd_date')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('วันที่แก้ไขข้อมูลล่าสุด');
            $table->string('upd_user_id', 5)->nullable(false)->comment('ผู้แก้ไขข้อมูล');
        });

        DB::statement(
            "ALTER TABLE " . $this->table_name . "
            ADD PRIMARY KEY (`profile_id` , `cert_seq`),
            ADD CONSTRAINT `FK_profile_cert_1` FOREIGN KEY (`profile_id`) REFERENCES `profile_t_master` (`profile_id`);"
        );
    }

    public function down()
    {
        Schema::dropIfExists($this->table_name);
    }
}
