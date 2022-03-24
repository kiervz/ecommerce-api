<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sellers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('store_id');
            $table->string('firstname', 191);
            $table->string('middlename', 191);
            $table->string('lastname', 191);
            $table->string('gender', 10);
            $table->date('birthday');
            $table->string('contact_no', 20);
            $table->string('address', 191);
            $table->integer('is_verified')->default(0);
            $table->string('id_number', 191);
            $table->string('id_card', 255);
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
        Schema::dropIfExists('sellers');
    }
}
