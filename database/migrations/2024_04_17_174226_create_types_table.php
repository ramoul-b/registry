<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('types', function (Blueprint $table) {
            $table->id();
            $table->string('country', 3);
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->string('business_type_code', 20)->nullable();
            $table->boolean('has_vat_code')->default(0);
            $table->boolean('required_vat_code')->default(0);
            $table->boolean('vat_code_in_unique')->default(0);
            $table->boolean('has_tax_identification')->default(0);
            $table->boolean('required_tax_identification')->default(0);
            $table->boolean('tax_identification_in_unique')->default(0);
            $table->boolean('has_name')->default(0);
            $table->boolean('required_name')->default(0);
            $table->boolean('has_surname')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('types');
    }
}
