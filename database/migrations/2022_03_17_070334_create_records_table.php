<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('records', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('job_type')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('records');
    }
};
