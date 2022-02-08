<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstallationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('installations')) {
            Schema::create('installations', function (Blueprint $table) {
                $table->id();
                $table->foreignId('application_id')
                    ->constrained()
                    ->cascadeOnUpdate()
                    ->restrictOnDelete();
                $table->foreignId('company_id')
                    ->constrained()
                    ->cascadeOnUpdate()
                    ->restrictOnDelete();
                $table->timestamps();

                $table->unique(['application_id', 'company_id']);
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
        Schema::dropIfExists('installations');
    }
}
