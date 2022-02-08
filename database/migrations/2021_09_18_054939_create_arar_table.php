<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateARARTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('arar')) {
            Schema::create('arar', function (Blueprint $table) {
                $table->id();
                $table->foreignId('application_role_id')
                    ->constrained()
                    ->cascadeOnUpdate()
                    ->restrictOnDelete();
                $table->foreignId('application_right_id')
                    ->constrained()
                    ->cascadeOnUpdate()
                    ->restrictOnDelete();
                $table->boolean('read')->default(false);
                $table->boolean('create')->default(false);
                $table->boolean('update')->default(false);
                $table->boolean('delete')->default(false);
                $table->boolean('publish')->default(false);
                $table->boolean('export')->default(false);
                $table->timestamps();
                $table->softDeletes();

                $table->unique(['application_role_id', 'application_right_id']);
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
        Schema::dropIfExists('arar');
    }
}
