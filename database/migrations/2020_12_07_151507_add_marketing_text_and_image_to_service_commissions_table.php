<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMarketingTextAndImageToServiceCommissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_commissions', function (Blueprint $table) {
            $table->text('marketing_text')->nullable()->after('service_link');
            $table->string('img_upload')->nullable()->after('marketing_text');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_commissions', function (Blueprint $table) {
            //
        });
    }
}
