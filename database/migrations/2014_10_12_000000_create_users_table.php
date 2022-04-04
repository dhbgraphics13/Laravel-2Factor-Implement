<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role',['A','M','D','U','P'])->default('U')->comment('a=>admin,m=>manager,d=>designer,p=>print man , u=>user');
            $table->enum('active',['Y','N'])->default('N');
            $table->enum('two_factor',['Y','N'])->default('N');
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('users')->insert(
            [
                'name' => 'Admin',
                'username' => 'admin',
                'email' => 'dhbgraphics.user@gmail.com',
                'password' => bcrypt(12345678),
                'role' => 'A',
                'active' => 'Y',
            ]);

        DB::table('users')->insert(
            [
                'name' => 'Gurjit Singh',
                'username' => 'gurjit',
                'email' => 'gurjit@dhbgraphics.com',
                'password' => bcrypt(12345678),
                'role' => 'D',
                'active' => 'Y',
            ]);

        DB::table('users')->insert(
            [
                'name' => 'Harpeet Singh',
                'username' => 'printman',
                'email' => 'happy@dhbgraphics.com',
                'password' => bcrypt(12345678),
                'role' => 'P',
                'active' => 'Y',
            ]);


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
