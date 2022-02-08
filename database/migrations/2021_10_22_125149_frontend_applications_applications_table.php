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
                /*$table->foreign('frontend_application_id', 'fk_faa_fa')
                    ->references('id')
                    ->on('frontend_applications')
                    ->cascadeOnUpdate()
                    ->restrictOnDelete();*/
                $table->bigInteger('application_id');
                $table->foreign('application_id', 'fk_faa_a')
                    ->references('id')
                    ->on('applications')
                    ->cascadeOnUpdate()
                    ->restrictOnDelete();
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
