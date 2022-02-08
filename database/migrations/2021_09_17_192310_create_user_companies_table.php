<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('user_companies')) {
            Schema::create('user_companies', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')
                    ->constrained()
                    ->cascadeOnUpdate()
                    ->restrictOnDelete();
                $table->foreignId('company_id')
                    ->constrained()
                    ->cascadeOnUpdate()
                    ->restrictOnDelete();
                $table->foreignId('role_id')
                    ->comment('Welke rol de gebruik heeft in het bedrijf.')
                    ->constrained()
                    ->cascadeOnUpdate()
                    ->restrictOnDelete();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_companies');
    }
}
