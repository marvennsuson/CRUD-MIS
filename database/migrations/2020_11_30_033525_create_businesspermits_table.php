<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinesspermitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('businesspermits', function (Blueprint $table) {
            $table->id();

            $table->string('app_id');
            $table->string('permit_type');
            $table->string('mode_of_payment');
            $table->string('business_type');
            $table->date('application_date')->nullable();
            $table->string('registration_no')->nullable();
            $table->string('tin_no')->nullable();
            $table->string('amendment')->nullable();
            $table->string('amendment_from')->nullable();
            $table->string('amendment_to')->nullable();
            $table->tinyInteger('is_change_owner');
            $table->string('prev_owner')->nullable();
            $table->string('new_owner')->nullable();
            $table->tinyInteger('is_enjoy_tax');
            $table->string('tax_entity')->nullable();
            $table->string('tp_last_name');
            $table->string('tp_first_name');
            $table->string('tp_middle_name');
            $table->string('business_name');
            $table->string('civil_status');
            $table->string('company_rep');
            $table->string('company_position');
            $table->string('trade_name');
            $table->mediumText('business_address');
            $table->string('business_postal');
            $table->string('business_email');
            $table->string('business_tel');
            $table->string('business_mobile');
            $table->mediumText('owner_address');
            $table->string('owner_postal');
            $table->string('owner_email');
            $table->string('owner_tel');
            $table->string('owner_mobile');
            $table->string('emergency_contact');
            $table->string('emergency_email');
            $table->string('emergency_tel');
            $table->string('emergency_mobile');
            $table->integer('business_area');
            $table->integer('male_in_establishments');
            $table->integer('female_in_establishments');
            $table->integer('male_in_lgu');
            $table->integer('female_in_lgu');
            $table->tinyInteger('is_business_rented');
            $table->string('lessor_name')->nullable();
            $table->mediumText('lessor_address')->nullable();
            $table->string('lessor_contact')->nullable();
            $table->string('monthly_rental')->nullable();
            $table->mediumText('business_activities');
            $table->mediumText('attachments')->nullable();
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
        Schema::dropIfExists('businesspermits');
    }
}
