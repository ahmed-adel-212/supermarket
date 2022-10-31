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
            $table->foreignId('user_id')->constrained()->onDelete('NO ACTION');
            $table->foreignId('address_id')->nullable()->constrained()->onDelete('NO ACTION');
            $table->enum('service_type', ['takeaway', 'delivery'])->default('delivery');
            $table->enum('status', ['pending', 'rejected', 'in-progress', 'completed', 'canceled'])->default('pending');
            $table->string('cancellation_reason')->nullable();
            $table->string('description_box')->nullable();
            $table->enum('payment_type', ['online', 'cash'])->default('cash');
            $table->double('subtotal');
            $table->double('total');
            $table->double('taxes')->default(0);
            $table->double('delivery_fees')->default(0);
            $table->integer('points')->default(0);
            $table->double('points_paid')->default(0);
            $table->double('offer_value')->default(0);
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
        Schema::dropIfExists('orders');
    }
};
