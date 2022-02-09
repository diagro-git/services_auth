<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FrontendApplicationsApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('frontend_applications_applications')) {
            Schema::create('frontend_applications_applications', function (Blueprint $table) {
                $table->bigInteger('frontend_application_id');
                $table->bigInteger('application_id');
                $table->timestamps();
                $table->softDeletes();

                $table->unique(['frontend_application_id', 'application_id'], 'idx_faa_fa_fa');
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
        Schema::dropIfExists('frontend_applications_applications');
    }
}
