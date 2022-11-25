<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->integer('channel_id')->nullable();
            $table->string('is_global')->default('Yes');
            $table->string('name');
            $table->string('alias')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('is_user_specific')->default(0);
            $table->tinyInteger('is_bypass_otp')->default(0);
            $table->tinyInteger('is_special_user_group')->default(0);
            $table->string('special_user_key')->nullable();
            $table->string('admin_user_ids')->nullable();
            $table->tinyInteger('is_super_group')->default(0);
            $table->string('child_group_ids')->nullable();
            $table->string('status');
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
        Schema::dropIfExists('groups');
    }
}










