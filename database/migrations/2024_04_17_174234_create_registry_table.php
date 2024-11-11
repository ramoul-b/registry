<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistryTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('registry', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type_id');
            $table->string('country', 3);
            $table->string('vat_code_country', 3)->nullable();
            $table->string('vat_code', 20)->nullable();
            $table->string('tax_identification_country', 3)->nullable();
            $table->string('tax_identification', 20)->nullable();
            $table->string('unique_code', 255)->nullable();
            $table->string('name', 255)->nullable();
            $table->string('surname', 255)->nullable();
            $table->string('business_name', 255)->nullable();
            $table->timestamps();

            $table->foreign('type_id')->references('id')->on('types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('registry');
    }
}
