<?php

use App\Models\FrontendApplication;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('tokens')) {
            Schema::create('tokens', function (Blueprint $table) {
                $table->id();
                $table->foreignIdFor(User::class);
                $table->enum('token_type', ['AT', 'AAT']);
                $table->longText('token')->unique();
                $table->tinyInteger('status');
                $table->foreignIdFor(User::class, 'revoked_by')->nullable();
                $table->string('revoked_reason')->nullable();
                $table->foreignIdFor(FrontendApplication::class, 'issuer');
                $table->string('device');
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
        Schema::dropIfExists('tokens');
    }
}
