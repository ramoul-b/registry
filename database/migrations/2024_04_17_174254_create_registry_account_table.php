<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistryAccountTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('registry_account', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('registry_id');
            $table->unsignedBigInteger('account_id');  // Assuming 'account_id' refers to an 'accounts' table
            $table->enum('type', ['creator', 'owner', 'user']);
            $table->timestamps();

            $table->foreign('registry_id')->references('id')->on('registry')->onDelete('cascade');
             //$table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('registry_account');
    }
}
