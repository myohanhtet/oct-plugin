<?php namespace Phyo\Articles\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateTagsTable extends Migration
{
    public function up()
    {
        Schema::create('phyo_articles_tags', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('tag_slug', 125)->index();
            $table->timestamps();
        });

        Schema::create('phyo_articles_post_tag', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('post_id');
            $table->integer('tag_id');
            $table->primary(['post_id', 'tag_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('phyo_articles_tags');
    }
}
