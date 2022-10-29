<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->unsignedBigInteger('lead_id');
            $table->unsignedBigInteger('moderator_id')->default(0);
            $table->unsignedBigInteger('admin_id')->default(0);
            $table->longText('description');
            $table->enum('type', ['meeting', 'call', 'vc', 'other']);
            $table->string('file');
            $table->string('file_name');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->enum('done', ['no', 'yes'])->default('no');
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
        Schema::dropIfExists('activities');
    }
};
