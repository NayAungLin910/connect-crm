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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->longText('description');
            $table->float('value');
            $table->unsignedBigInteger('source_id');
            $table->enum('progress', ['new', 'follow up', 'prospect', 'negotiation', 'won', 'lost'])->default('new');
            $table->unsignedBigInteger('moderator_id')->default(0);
            $table->unsignedBigInteger('admin_id')->default(0);
            $table->dateTime('close_date');
            $table->unsignedBigInteger('contact_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('quantity');
            $table->float('amount');
            $table->unsignedBigInteger('business_id');
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
        Schema::dropIfExists('leads');
    }
};
