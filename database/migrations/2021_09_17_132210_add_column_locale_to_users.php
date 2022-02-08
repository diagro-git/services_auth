<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnLocaleToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasColumn('users', 'locale_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->foreignId('locale_id')
                    ->constrained()
                    ->cascadeOnUpdate()
                    ->restrictOnDelete();
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('locale_id');
        });
    }
}
