<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('telephone')->nullable();
            $table->string('website')->nullable();
            $table->longText('note')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
