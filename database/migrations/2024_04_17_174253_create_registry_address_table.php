<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistryAddressTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('registry_address', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('registry_id');
            $table->unsignedBigInteger('address_id');  // Assuming 'address_id' refers to an 'addresses' table
            $table->enum('type', ['home', 'contract', 'business']);
            $table->timestamps();

            $table->foreign('registry_id')->references('id')->on('registry')->onDelete('cascade');
            //$table->foreign('address_id')->references('id')->on('addresses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('registry_address');
    }
}
