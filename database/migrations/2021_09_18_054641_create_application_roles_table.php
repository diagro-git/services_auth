<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('application_roles')) {
            Schema::create('application_roles', function (Blueprint $table) {
                $table->id();
                $table->foreignId('application_id')
                    ->constrained()
                    ->cascadeOnUpdate()
                    ->restrictOnDelete();
                $table->foreignId('role_id')
                    ->constrained()
                    ->cascadeOnUpdate()
                    ->restrictOnDelete();
                $table->timestamps();

                $table->unique(['application_id', 'role_id']);
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
        Schema::dropIfExists('application_roles');
    }
}
