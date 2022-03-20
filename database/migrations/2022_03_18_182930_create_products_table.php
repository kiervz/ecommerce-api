<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sku', 191);
            $table->string('name', 191);
            $table->string('slug', 191);
            $table->decimal('unit_price', 7, 2);
            $table->decimal('discount', 3, 2);
            $table->integer('stock');
            $table->string('description', 191);
            $table->integer('seller_id');
            $table->integer('brand_id');
            $table->integer('segment_id');
            $table->integer('category_id');
            $table->integer('sub_category_id');
            $table->timestamps();
            $table->timestamps('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
