<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->text('designer_id')->nullable();
            $table->text('title')->nullable();
            $table->text('style')->nullable();
            $table->text('price')->nullable();
            $table->text('fullPrice')->nullable();
            $table->text('productionTime')->nullable();
            $table->text('footage')->nullable();
            $table->text('chooseOption')->nullable();
            $table->text('section')->nullable();
            $table->text('description')->nullable();
            $table->text('plans')->nullable();
            $table->text('images')->nullable();
            $table->text('drawing')->nullable();
            $table->text('hash')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
