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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->dateTime('date_from');
            $table->dateTime('date_to');
            $table->text('description');
            $table->string('image')->nullable();
            $table->enum('offer_type', ['discount', 'buy-get'])->default('discount');
            $table->enum('service_type', ['takeaway', 'delivery'])->default('delivery');
            $table->boolean('main')->default(false);
            $table->double('offer_value')->comment('offer price or discount value');
            // discount offer
            $table->enum('discount_type', ['value', 'percentage', 'free'])->default('percentage');
            // buy-and-get offer
            $table->integer('get_quantity')->nullable();
            $table->integer('buy_quantity')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offers');
    }
};
