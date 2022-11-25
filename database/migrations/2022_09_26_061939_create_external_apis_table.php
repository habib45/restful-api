<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExternalApisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('external_apis', function (Blueprint $table) {
            $table->id();
            $table->string('name',255);
            $table->enum('api_type', ['POST', 'GET'])->default('GET');
            $table->string('api_key',255);
            $table->string('secret',255);
            $table->string('url',255);
            $table->string('key',255);
            $table->boolean('is_form_field_mapped_api')->default(true);;
            $table->string('request_generation_method',255)->nullable();
            $table->string('request_parameter',255)->nullable();
            $table->text('extra_config')->nullable();
            $table->text('response_parameter')->nullable();
            $table->text('mock_response_parameter')->nullable();
            $table->text('mock_request_parameter')->nullable();
            $table->text('mock_header_parameter')->nullable();
            $table->text('request_header')->nullable();
            $table->text('response')->nullable();
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->foreignId('created_by')->index()->comment("Created by")->nullable();
            $table->foreignId('updated_by')->index()->comment("Updated by")->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('external_apis');
    }
}
