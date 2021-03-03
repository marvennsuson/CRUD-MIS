<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('app_id');
            $table->integer('user_id');
            $table->tinyInteger('status');
            $table->tinyInteger('type');
            $table->integer('verified_by')->nullable();
            $table->dateTime('verified_date', 0)->nullable();
            $table->mediumText('notes')->nullable();
            $table->mediumText('user_notes')->nullable();
            $table->integer('amount')->nullable();
            $table->integer('treasurer')->nullable();
            $table->string('paymentType')->nullable();
            $table->string('dateofPay')->nullable();
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
        Schema::dropIfExists('applications');
    }
}
