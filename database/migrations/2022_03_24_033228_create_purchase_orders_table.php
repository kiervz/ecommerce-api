<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('seller_id');
            $table->integer('customer_id');
            $table->string('ref_no', 30);
            $table->date('po_date');
            $table->decimal('total_quantity', 12, 2);
            $table->decimal('total_amount', 12, 2);
            $table->string('status', 1);
            $table->integer('payment_mode_id');
            $table->string('payment_status', 1);
            $table->decimal('paid_amount', 12, 2);
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
        Schema::dropIfExists('purchase_orders');
    }
}
