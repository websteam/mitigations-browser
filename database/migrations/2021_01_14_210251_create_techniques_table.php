<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTechniquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('techniques', function (Blueprint $table) {
            $table->string('id')->unique();
            $table->string('parent_id')->nullable();
            $table->string('external_id')->nullable();

            $table->string('name');
            $table->text('description');
            $table->string('version')->nullable();

            $table->timestamps();

            $table->primary('id');
            $table->foreign('parent_id')
                ->references('id')->on('techniques')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('techniques');
    }
}
