<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessPermitVerificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_permit_verifications', function (Blueprint $table) {
            $table->id();
            $table->string('app_id');
            $table->tinyInteger('locational_clearance');
            $table->tinyInteger('occupancy_permit');
            $table->tinyInteger('barangay_clearance');
            $table->tinyInteger('sanitary_permit');
            $table->tinyInteger('city_environmental_certificate');
            $table->tinyInteger('vet_clearance');
            $table->tinyInteger('market_clearance');
            $table->tinyInteger('fire_cert');
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
        Schema::dropIfExists('business_permit_verifications');
    }
}
