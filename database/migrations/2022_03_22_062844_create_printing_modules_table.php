<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('printing_modules', function (Blueprint $table) {
            $table->id();
            $table->string('module_name');
            $table->integer('parent_id')->nullable();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->enum('active', ['Y', 'N'])->default('Y');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('printing_modules');
    }
};
