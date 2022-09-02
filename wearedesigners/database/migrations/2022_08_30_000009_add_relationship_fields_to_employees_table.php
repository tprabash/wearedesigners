<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToEmployeesTable extends Migration
{
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id', 'company_fk_7230023')->references('id')->on('companies');
        });
    }
}
