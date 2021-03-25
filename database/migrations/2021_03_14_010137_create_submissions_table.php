<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submissions', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');

            $table->string('email', 128);
            $table->string('person_in_charge', 64);
            $table->string('phone_number', 32);
            $table->string('agency', 128);
            $table->text('goal', 2048);
            $table->date('start_date');

            $table->string('proposal_link', 256);
            $table->string('cover_letter_link', 256);
            
            $table->string('attachment_link', 256)->nullable();
            $table->text('note', 2048)->nullable();
            $table->enum('status', ['processed', 'accepted', 'rejected'])->nullable();
            $table->boolean('email_sent')->nullable()->default(false);
            
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
        Schema::dropIfExists('submissions');
    }
}
