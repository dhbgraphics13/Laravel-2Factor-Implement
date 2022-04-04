<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('user_id')->nullable()->comment('designer_name');
            $table->enum('status',['1','2','3','4','5','0'])->default('1')->comment('1=>designing,2=>approved,3=>Printing,4=>Ready for Pickup,5=>pickedUp,0=>cancel');
            $table->date('due_date')->nullable();
            $table->string('payment_method')->nullable();
            $table->decimal('total_price',18,4)->nullable();
            $table->string('approved_by')->nullable();
            $table->string('approved_by_information')->nullable();
            $table->string('ready_for_print')->nullable();
            $table->string('printed_by')->nullable();
            $table->string('file')->nullable();
            $table->string('uploaded_by')->nullable();
            $table->string('uploader_id')->nullable();
            $table->text('file_print_instructions')->nullable();
            $table->string('picked_by_information')->nullable();
            $table->timestamps();
        });
    }

 /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
