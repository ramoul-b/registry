<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistryValuesDecimalTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('registry_values_decimal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('registry_id');
            $table->unsignedBigInteger('attribute_id');
            $table->decimal('value', 20, 3);  // Ensure precision and scale meet your requirements
            $table->timestamps();

            $table->foreign('registry_id')->references('id')->on('registry')->onDelete('cascade');
            $table->foreign('attribute_id')->references('id')->on('attributes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('registry_values_decimal');
    }
}
