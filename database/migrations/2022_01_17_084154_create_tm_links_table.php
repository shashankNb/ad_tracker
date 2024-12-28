<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tm_links', function (Blueprint $table) {
            $table->id();
            $table->string('link_name', 191);
            $table->foreignId('tracking_link_id')->constrained('tm_tracking_links')->onDelete('restrict');
            $table->string('tracking_slug', 191);
            $table->string('primary_url', 191);
            $table->foreignId('group_id')->constrained('tm_link_groups')->onDelete('restrict');
            $table->foreignId('network_id')->constrained('tm_networks')->onDelete('restrict');
            $table->integer('is_action')->default(0);
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
        Schema::dropIfExists('tm_links');
    }
}
