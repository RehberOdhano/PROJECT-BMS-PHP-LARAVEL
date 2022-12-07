<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('distribution_id');
            $table->string("delivery_date");
            $table->string("invoice_number");
            $table->json("product_code");
            $table->json("product_name");
            $table->json("pkg_size");
            $table->json("pkg_type");
            $table->json("unit_price");
            $table->json("reg_discount");
            $table->json("adv_income_tax");
            $table->json("quantity");
            $table->json("total_amount");
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
        Schema::dropIfExists('stocks');
    }
}
