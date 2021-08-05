<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_templates', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('display_type')->default(0);
            $table->string('name', 200);
            $table->string('subject_en')->nullable();
            $table->string('subject_ar')->nullable();
            $table->string('template_en')->nullable();
            $table->string('template_ar')->nullable();
            $table->boolean('is_popup')->default(0);
            $table->string('popup_image', 500)->nullable();
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
        Schema::dropIfExists('notification_templates');
    }
}
