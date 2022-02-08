<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IsoColumnLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasColumn('languages', 'code') && ! Schema::hasColumn('languages', 'iso_639_2')) {
            Schema::table('languages', function (Blueprint $table) {
                $table->dropColumn('code');
                $table->char('iso_639_2', 3)
                    ->unique()
                    ->comment('ISO 639-2. For example NLD, FRA, ...');
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
        Schema::table('countries', function (Blueprint $table) {
            $table->dropColumn('iso_639_2');
        });
    }
}
