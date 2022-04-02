<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBucsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bucs', function (Blueprint $table) {
            $table->id();
            $table->string('rab_no', 50)->nullable();
            $table->date('date')->nullable();
            $table->string('description');
            $table->string('project_code', 10)->nullable();
            $table->double('budget')->nullable();
            $table->string('status', 20)->nullable();
            $table->string('filename')->nullable();
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
        Schema::dropIfExists('bucs');
    }
}
