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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('NO ACTION');
            $table->foreignId('order_id')->nullable()->constrained()->onDelete('NO ACTION');
            $table->string('payment_id')->comment('bank payment id');
            $table->enum('status', ['rejected', 'completed', 'pending'])->default('pending');
            $table->string('message')->nullable();
            $table->text('data')->nullable();
            $table->string('hash')->nullable();
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
        Schema::dropIfExists('payments');
    }
};
