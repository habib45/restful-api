<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = 'channels';
        if(!Schema::hasTable($tableName)){
            Schema::create($tableName, function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('track_id');
                $table->string('name',100)->nullable(false);
                $table->string('namespace',100)->nullable();
                $table->string('description',250)->nullable();
                $table->string('status',50)->default('Active');
                $table->timestamps();
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
        $tableName = 'channels';
        Schema::dropIfExists($tableName);
    }
}
