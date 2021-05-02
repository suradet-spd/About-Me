<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ProfileTLearningList extends Migration
{
    private $table_name = "profile_t_learning_list";
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->string('learning_list_id' , 5)->primary()->comment('รหัสระดับการศึกษา');
            $table->string('learning_desc_th')->nullable(false)->comment('ระดับการศึกษา (ไทย)');
            $table->string('learning_desc_en')->nullable(false)->comment('ระดับการศึกษา (อังกฤษ)');
            $table->string('active_flag' , 1)->default('Y')->comment('สถานะการใช้งาน');
            /*
                Y = Active
                N = Non Active
            */
            $table->dateTime('last_upd_date')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('วันที่แก้ไขข้อมูลล่าสุด');
            $table->string('upd_user_id', 5)->nullable(false)->comment('ผู้แก้ไขข้อมูล');
        });
    }

    public function down()
    {
        Schema::dropIfExists($this->table_name);
    }
}
