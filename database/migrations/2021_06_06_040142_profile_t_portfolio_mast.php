<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ProfileTPortfolioMast extends Migration
{
    private $table_name = "profile_t_portfolio";
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->string('profile_id' , 5)->comment('รหัสผู้ใช้งาน');
            $table->integer('portfolio_seq')->comment('ลำดับชิ้นงาน');
            $table->string('portfolio_name_th')->nullable(true)->comment('ชื่อผลงาน (ไทย)');
            $table->string('portfolio_name_en')->nullable(true)->comment('ชื่อผลงาน (อังกฤษ)');
            $table->string('portfolio_tag')->nullable(false)->comment('แท็กของชิ้นงาน');
            $table->string('portfolio_images')->nullable(false)->comment('รูปภาพชิ้นงาน');
            $table->string('portfolio_desc_th' , 500)->nullable(true)->comment('อธิบายเกี่ยวกับชิ้นงาน (ไทย)');
            $table->string('portfolio_desc_en' , 500)->nullable(true)->comment('อธิบายเกี่ยวกับชิ้นงาน (อังกฤษ)');
            $table->dateTime('last_upd_date')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('วันที่แก้ไขข้อมูลล่าสุด');
            $table->string('upd_user_id', 5)->nullable(false)->comment('ผู้แก้ไขข้อมูล');
        });

        DB::statement(
            "ALTER TABLE " . $this->table_name . "
            ADD PRIMARY KEY (`profile_id` , `portfolio_seq`),
            ADD CONSTRAINT `FK_profile_portfolio_1` FOREIGN KEY (`profile_id`) REFERENCES `profile_t_master` (`profile_id`);"
        );
    }

    public function down()
    {
        Schema::dropIfExists($this->table_name);
    }
}
