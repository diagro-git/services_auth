<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('locales')) {
            Schema::create('locales', function (Blueprint $table) {
                $table->id();
                $table->string('identifier', 10)->unique();
                $table->foreignId('language_id')
                    ->constrained()
                    ->cascadeOnUpdate()
                    ->restrictOnDelete();
                $table->timestamps();
                $table->softDeletes();
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
        Schema::dropIfExists('locales');
    }
}
