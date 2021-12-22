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
            $table->text('userId');
            $table->text('title');
            $table->text('style');
            $table->text('author');
            $table->text('price');
            $table->text('fullPrice');
            $table->text('productionTime');
            $table->text('footage');
            $table->text('chooseOption');
            $table->text('section');
            $table->text('description');
            $table->text('plans');
            $table->text('images');
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
