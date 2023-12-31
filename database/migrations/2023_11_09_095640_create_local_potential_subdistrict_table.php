<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocalPotentialSubdistrictTable extends Migration
{
    public function up()
    {
        Schema::create('local_potential_subdistrict', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_local_potential');
            $table->unsignedBigInteger('subdistrict_id');
            // Add any additional columns you need for the pivot table here

            // Foreign keys
            $table->foreign('id_local_potential')->references('id')->on('local_potentials')->onDelete('cascade');
            $table->foreign('subdistrict_id')->references('id')->on('ms_subdistricts')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('local_potential_subdistrict');
    }
}
