<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ProfileTLogin extends Migration
{
    private $table_name = "profile_t_master";
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->string('profile_id' , 5)->primary()->comment('รหัสผู้ใช้งาน');
            $table->string('name_th', 100)->nullable(false)->comment('ชื่อผู้ใช้งาน (ไทย)');
            $table->string('name_en', 100)->nullable(false)->comment('ชื่อผู้ใช้งาน (อังกฤษ)');
            $table->string('nickname')->nullable(false)->comment('ชื่อเล่น');
            $table->string('photo_name')->nullable(false)->comment('ชื่อรูปโปรไฟล์ผู้ใช้งาน');
            $table->string('location_id' , 5)->nullable(true)->comment('รหัสที่อยู่');
            $table->string('telephone' , 15)->nullable(true)->comment('เบอร์โทรศัพท์');
            $table->string('about_th' , 2000)->nullable(true)->comment('อธิบายตัวตน (ไทย)');
            $table->string('about_en' , 2000)->nullable(true)->comment('อธิบายตัวตน (อังกฤษ)');
            $table->string('email')->unique()->comment('บัญชีอีเมล์');
            $table->string('telephone')->unique()->comment('เบอร์โทรศัพท์');
            $table->string('password')->nullable(false)->comment('รหัสผ่าน');
            $table->rememberToken()->comment('key การจดจำรหัสผ่าน');
            $table->string('language_flag' , 1)->default('N')->comment('สถานะการตั้งค่าภาษา');
            /*
                N = Not set
                E = English only
                T = Thai only
                A = English & Thai
            */
            $table->string('gen_profile_flag' , 1)->default('N')->comment('สถานะการสร้างบัญชี');
            /*
                Y = Yes (success Create)
                N = No (Non create)
            */
            $table->string('admin_flag' , 1)->default('N')->comment('สถานะผู้ใช้งาน');
            /*
                Y = Yes (Admin)
                N = No (user)
            */
            $table->dateTime('create_date')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('วันที่สร้างข้อมูล');
            $table->dateTime('last_upd_date')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('วันที่แก้ไขข้อมูลล่าสุด');
            $table->string('upd_user_id', 5)->nullable(false)->comment('ผู้แก้ไขข้อมูล');

        });
    }

    public function down()
    {
        Schema::dropIfExists($this->table_name);
    }
}
