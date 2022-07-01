<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUCARTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('ucar')) {
            Schema::create('ucar', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_company_id')
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

                $table->unique(['user_company_id', 'application_right_id', 'deleted_at'], 'ucar_idx_1');
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
        Schema::dropIfExists('ucar');
    }
}
