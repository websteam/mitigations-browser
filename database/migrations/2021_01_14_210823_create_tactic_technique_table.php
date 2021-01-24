<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTacticTechniqueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tactic_technique', function (Blueprint $table) {
            $table->string('tactic_id');
            $table->string('technique_id');

            $table->foreign('tactic_id')
                ->references('id')
                ->on('tactics');
            $table->foreign('technique_id')
                ->references('id')
                ->on('techniques');

            $table->primary(['tactic_id', 'technique_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tactic_technique');
    }
}
