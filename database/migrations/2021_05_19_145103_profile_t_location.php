<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ProfileTLocation extends Migration
{
    private $table_name = "profile_t_location";
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->string('location_id' , 5)->primary()->comment('รหัสที่อยู่');
            $table->string('province_code' , 5)->nullable(false)->comment('รหัสจังหวัด');
            $table->string('province_th')->nullable(false)->comment('จังหวัด (ไทย)');
            $table->string('province_en')->nullable(false)->comment('จังหวัด (อังกฤษ)');
            $table->string('district_code')->nullable(false)->comment('รหัสอำเภอ');
            $table->string('district_th')->comment('อำเภอ (ไทย)');
            $table->string('district_en')->comment('อำเภอ (อังกฤษ)');
            $table->string('sub_district_code')->comment('รหัสตำบล');
            $table->string('sub_district_th')->comment('ตำบล (ไทย)');
            $table->string('sub_district_en')->comment('ตำบล (อังกฤษ)');
            $table->dateTime('last_upd_date')->default(DB::raw('CURRENT_TIMESTAMP()'))->comment('วันที่แก้ไขข้อมูลล่าสุด');
            $table->string('upd_user_id' , 5)->nullable(false)->comment('ผู้แก้ไขข้อมูล');
        });
    }

    public function down()
    {
        Schema::dropIfExists($this->table_name);
    }
}
