<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistrictTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Masterdata.district', function (Blueprint $table) {
            $table->id('district_code');
            $table->bigInteger('state_code');
            $table->string('district_name');
            $table->string('created_on');
            $table->foreign('state_code')->references('state_code')->on('Masterdata.state');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Masterdata.district');
    }
}
