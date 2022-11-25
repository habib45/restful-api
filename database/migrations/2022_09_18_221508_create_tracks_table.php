<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTracksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = 'tracks';
        if(!Schema::hasTable($tableName))
        {
            Schema::create($tableName, function (Blueprint $table) {
                $table->id();
                $table->string('name',100)->nullable(false);
                $table->string('description',450)->nullable();
                $table->string('status',450)->default('Active')->nullable();
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
        Schema::dropIfExists('tracks');
    }
}
