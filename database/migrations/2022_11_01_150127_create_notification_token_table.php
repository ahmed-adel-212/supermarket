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
		Schema::create('notification_token', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
			$table->string('token', 191)->nullable();
			$table->softDeletes();
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
		Schema::drop('noti_tokens');
	}
};
