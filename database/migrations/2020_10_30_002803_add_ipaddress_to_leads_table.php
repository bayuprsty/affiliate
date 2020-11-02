<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIpaddressToLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->string('ip_address')->nullable()->after('vendor_id');
            $table->string('customer_name')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->string('no_telepon')->nullable()->change();
            $table->date('date')->nullable()->change();
            $table->integer('status')->default(1)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('leads', function (Blueprint $table) {
            //
        });
    }
}
