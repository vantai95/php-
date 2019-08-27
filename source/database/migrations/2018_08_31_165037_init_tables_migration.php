<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InitTablesMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('code');
            $table->string('name');
            $table->text('permissions')->nullable();
        });

        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('content')->nullable();
            $table->text('note')->nullable();
            $table->integer('sequence');
            $table->integer('province_id');
        });

        Schema::create('provinces', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('name_en')->nullable();
            $table->string('name_vi')->nullable();
        });

        Schema::create('register_advices', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('status')->default(true);
            $table->integer('service_id');
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->boolean('active')->default(true);
            $table->integer('sequence');
            $table->integer('type')->nullable();
            $table->string('name_en')->nullable();
            $table->string('name_vi')->nullable();
            $table->string('slug');
            $table->longtext('description_en')->nullable();
            $table->longtext('description_vi')->nullable();
        });

        Schema::create('sub_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->boolean('active')->default(true);
            $table->integer('category_id');
            $table->integer('sequence');
            $table->string('name_en')->nullable();
            $table->string('name_vi')->nullable();
            $table->string('slug');
            $table->longtext('description_en')->nullable();
            $table->longtext('description_vi')->nullable();
            $table->integer('parent_id')->nullable();
        });

        Schema::create('categories_items', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('sequence');
            $table->integer('category_id');
            $table->integer('sub_category_id')->nullable();
            $table->integer('item_id');
        });

        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->boolean('active')->default(true);
            $table->string('name_en')->nullable();
            $table->string('name_vi')->nullable();
            $table->string('slug');
            $table->text('short_description_en')->nullable();
            $table->text('short_description_vi')->nullable();
            $table->longtext('description_en')->nullable();
            $table->longtext('description_vi')->nullable();
            $table->string('image')->nullable();
            $table->string('thumb_image')->nullable();
            $table->string('video')->nullable();
            $table->double('price');
            $table->integer('sub_sub_category_id')->nullable();
        });

        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->boolean('active')->default(true);
            $table->string('name_en')->nullable();
            $table->string('name_vi')->nullable();
            $table->string('slug');
            $table->longtext('description_en')->nullable();
            $table->longtext('description_vi')->nullable();
            $table->string('image')->nullable();
            $table->string('video')->nullable();
            $table->integer('event_type_id');
            $table->string('location')->nullable();
            $table->string('timeline')->nullable();
            $table->datetime('date_begin')->nullable();
        });

        Schema::create('event_types', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->boolean('active')->default(true);
            $table->string('name_en')->nullable();
            $table->string('name_vi')->nullable();
            $table->string('slug');
        });

        Schema::create('news', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->boolean('active')->default(true);
            $table->string('name_en')->nullable();
            $table->string('name_vi')->nullable();
            $table->string('slug');
            $table->text('short_description_en')->nullable();
            $table->text('short_description_vi')->nullable();
            $table->longtext('description_en')->nullable();
            $table->longtext('description_vi')->nullable();
            $table->string('image')->nullable();
            $table->integer('news_type_id');
        });

        Schema::create('news_types', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->boolean('active')->default(true);
            $table->string('name_en')->nullable();
            $table->string('name_vi')->nullable();
            $table->string('slug');
        });

        Schema::create('galleries', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('name_en')->nullable();
            $table->string('name_vi')->nullable();
            $table->boolean('active')->default(true);
            $table->text('images')->nullable();
            $table->integer('gallery_type_id');
        });

        Schema::create('gallery_types', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->boolean('active')->default(true);
            $table->string('name_en')->nullable();
            $table->string('name_vi')->nullable();
            $table->string('code')->nullable();
            $table->string('slug');
        });

        Schema::create('promotions', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->boolean('active')->default(true);
            $table->string('name_en')->nullable();
            $table->string('name_vi')->nullable();
            $table->string('slug');
            $table->text('short_description_en')->nullable();
            $table->text('short_description_vi')->nullable();
            $table->longtext('description_en')->nullable();
            $table->longtext('description_vi')->nullable();
            $table->string('image')->nullable();
            $table->string('video')->nullable();
            $table->integer('sequence');
            $table->boolean('enable_detail_page')->default(false);
            $table->date('begin_date')->nullable();
            $table->date('end_date')->nullable();
        });

        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->boolean('active')->default(true);
            $table->string('name_en')->nullable();
            $table->string('name_vi')->nullable();
            $table->string('url')->nullable();
            $table->integer('sequence');
        });

        Schema::create('sub_menus', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->boolean('active')->default(true);
            $table->string('name_en')->nullable();
            $table->string('name_vi')->nullable();
            $table->string('url');
            $table->integer('sequence');
            $table->integer('menu_id');
        });

        Schema::create('configurations', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('config_type');
            $table->string('config_key');
            $table->text('config_value')->nullable();
        });

        Schema::create('email_templates', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('name_en')->nullable();
            $table->string('name_vi')->nullable();
            $table->longtext('description_en')->nullable();
            $table->longtext('description_vi')->nullable();
            $table->boolean('active')->default(true);
        });

        Schema::create('images', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('image')->nullable();
        });

        Schema::create('famous_people', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('name_en')->nullable();
            $table->string('name_vi')->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_vi')->nullable();
            $table->string('image')->nullable();
            $table->string('video')->nullable();
            $table->boolean('active')->default(true);
            $table->string('slug');
        });

        Schema::create('services', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->boolean('active')->default(true);
            $table->string('name_en')->nullable();
            $table->string('name_vi')->nullable();
            $table->string('slug');
            $table->integer('sequence')->nullable()->default(0);
            $table->integer('category_id');
            $table->text('short_description_en')->nullable();
            $table->text('short_description_vi')->nullable();
            $table->longtext('description_en')->nullable();
            $table->longtext('description_vi')->nullable();
            $table->string('image')->nullable();
            $table->string('image_before')->nullable();
            $table->string('image_after')->nullable();
            $table->string('video')->nullable();
            $table->string('faqs')->nullable();
            $table->string('services_feedbacks')->nullable();
            $table->double('price')->nullable();
            $table->string('promotions')->nullable();
        });
        Schema::create('faqs', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->text('question_en')->nullable();
            $table->text('question_vi')->nullable();
            $table->text('anwser_en')->nullable();
            $table->text('anwser_vi')->nullable();
        });

        Schema::create('services_feedbacks', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('image')->nullable();
            $table->string('video')->nullable();
            $table->text('name_en')->nullable();
            $table->text('name_vi')->nullable();
            $table->longtext('description_en')->nullable();
            $table->longtext('description_vi')->nullable();
        });

        Schema::create('newsletters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email')->nullable();
            $table->boolean('status')->default(true);
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
        Schema::dropIfExists('roles');
        Schema::dropIfExists('contacts');
        Schema::dropIfExists('provinces');
        Schema::dropIfExists('register_advices');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('sub_categories');
        Schema::dropIfExists('categories_items');
        Schema::dropIfExists('items');
        Schema::dropIfExists('events');
        Schema::dropIfExists('event_types');
        Schema::dropIfExists('news');
        Schema::dropIfExists('news_types');
        Schema::dropIfExists('galleries');
        Schema::dropIfExists('gallery_types');
        Schema::dropIfExists('promotions');
        Schema::dropIfExists('menus');
        Schema::dropIfExists('sub_menus');
        Schema::dropIfExists('configurations');
        Schema::dropIfExists('email_templates');
        Schema::dropIfExists('images');
        Schema::dropIfExists('famous_people');
        Schema::dropIfExists('services');
        Schema::dropIfExists('faqs');
        Schema::dropIfExists('services_faqs');
        Schema::dropIfExists('services_feedbacks');
        Schema::dropIfExists('newsletters');
    }
}
