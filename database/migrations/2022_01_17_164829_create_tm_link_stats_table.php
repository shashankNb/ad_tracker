<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmLinkStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tm_link_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('link_id')->constrained('tm_links')->onDelete('restrict');
            $table->double('click_id', 191);
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->integer('action')->default(0);
            $table->string('subId_1', 191)->nullable();
            $table->string('subId_2', 191)->nullable();
            $table->string('subId_3', 191)->nullable();
            $table->string('subId_4', 191)->nullable();
            $table->string('subId_5', 191)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tm_link_stats');
    }
}
