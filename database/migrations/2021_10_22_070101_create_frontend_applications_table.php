<?php

use App\Models\FrontendApplication;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFrontendApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('frontend_applications')) {
            Schema::create('frontend_applications', function (Blueprint $table) {
                $table->id();
                $table->string('name', 50)->unique();
                $table->string('description');
                $table->tinyInteger('app_type', false, true)
                    ->default(FrontendApplication::TYPE_WEB);
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
        Schema::dropIfExists('frontend_applications');
    }
}
