<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkerApplicationStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Worker.worker_application_status', function (Blueprint $table) {
            $table->id();
            $table->integer('application_status');
            $table->string('remarks');
            $table->string('application_id');
            $table->integer('role_id');
            $table->integer('user_id');
            $table->integer('office_id');
            $table->string('from_user');
            $table->string('to_user');
            $table->timestamp('expiry')->nullable();
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
        Schema::dropIfExists('Worker.worker_application_status');
    }
}
