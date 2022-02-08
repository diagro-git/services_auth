<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationRightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('application_rights')) {
            Schema::create('application_rights', function (Blueprint $table) {
                $table->id();
                $table->foreignId('application_id')
                    ->constrained()
                    ->restrictOnDelete()
                    ->cascadeOnUpdate();
                $table->string('name', 30);
                $table->text('description');
                $table->timestamps();
                $table->softDeletes();

                $table->unique(['application_id', 'name']);
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
        Schema::dropIfExists('application_rights');
    }
}
