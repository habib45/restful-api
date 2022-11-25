<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('api_apps_id')->nullable()->index();
            $table->string('gp_user_id',20)->nullable()->index();
            $table->string('username',255)->unique()->index();
            $table->string('password',255)->nullable();
            $table->string('name',150)->nullable();
            $table->string('email',150)->unique()->index();
            $table->text('bio')->nullable();
            $table->string('image',255)->nullable();
            $table->string('mobile',15)->unique()->index();
            $table->string('designation',255)->nullable();
            $table->string('activation_key',80)->nullable();
            $table->string('reset_code',50)->nullable();
            $table->boolean('is_email_verified')->default(0);
            $table->boolean('email_notification_enable')->default(false);
            $table->boolean('sms_notification_enable')->default(false);
            $table->string('timezone',100)->nullable();
            $table->string('status',20)->default('Inactive')->index();
            $table->tinyInteger('sys_user')->default(0);
            $table->bigInteger('active_channel')->nullable();
            $table->rememberToken();
            $table->bigInteger('created_by')->nullable();
            $table->timestamps();
            $table->bigInteger('updated_by')->nullable();
            $table->softDeletes('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
