<?php namespace Phyo\Articles\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreatePostsTable extends Migration
{
    public function up()
    {
        Schema::create('phyo_articles_posts', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('slug',125)->index();
            $table->text('excerpt')->nullable();
            $table->text('title');
            $table->text('body');
            $table->timestamp('published_at')->nullable();
            $table->boolean('is_published')->default(false);
            $table->integer('user_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('phyo_articles_posts');
    }
}
