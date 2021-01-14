<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTacticsTechniquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tactics_techniques', function (Blueprint $table) {
            $table->id();
            $table->string('source_id');
            $table->string('target_id');

            $table->foreign('source_id')
                ->references('id')
                ->on('tactics');
            $table->foreign('target_id')
                ->references('id')
                ->on('techniques');

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
        Schema::dropIfExists('tactics_techniques');
    }
}
