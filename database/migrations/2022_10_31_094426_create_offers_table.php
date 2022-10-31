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
            $table->integer('quantity')->comment('or buy quantity');
            $table->double('offer_price')->comment('or discount value');
            // discount offer
            $table->enum('discount_type', ['value', 'percentage'])->nullable();
            // buy-and-get offer
            $table->integer('get_quantity')->nullable();
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
