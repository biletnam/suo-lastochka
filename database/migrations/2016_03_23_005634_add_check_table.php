<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCheckTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number');
            $table->date('admission_date')->index();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('tickets', function (Blueprint $table) {
            $table->integer('check_id')->unsigned()->default(null);

            //$table->foreign('check_id')->references('id')->on('checks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tickets', function (Blueprint $table) {
            //$table->dropForeign(['check_id']);

            $table->dropColumn('check_id');
        });

        Schema::table('checks', function (Blueprint $table) {
            $table->dropIndex(['admission_date']);
        });

        Schema::drop('checks');
    }
}
