<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NameColumnsCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasColumn('countries', 'name_international') && ! Schema::hasColumn('countries', 'name_native') && ! Schema::hasColumn('countries', 'iso_3166_1') && Schema::hasColumn('countries', 'name')) {
            Schema::table('countries', function (Blueprint $table) {
                $table->renameColumn('name', 'name_native');
                $table->string('name_international');
                $table->char('iso_3166_1', 3)
                    ->unique()
                    ->comment('ISO 3166-1 Alpha 3 code. For example BEL, NED, ...');
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
            $table->renameColumn('name_native', 'name');
            $table->dropColumn('name_international');
            $table->dropColumn('iso_3166_1');
        });
    }
}
