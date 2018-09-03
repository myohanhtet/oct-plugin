<?php namespace Phyo\Articles\Controllers;

use Backend\Facades\BackendAuth;
use BackendMenu;
use Backend\Classes\Controller;
use October\Rain\Support\Facades\Flash;

/**
 * Post Back-end Controller
 */
class Post extends Controller
{

//    public $requiredPermissions = ['phyo.articles.manage_post'];

    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Phyo.Articles', 'articles', 'post');
    }

    public function create_onSave()
    {
        if (!$this->user->hasPermission('phyo.articles.post_create')){
            Flash::error("No Permission!!");
            return back();
        }
        $post = new \Phyo\Articles\Models\Post();
        $post = $this->savePost($post);

        Flash::success('Post Saved Successfully');

        return $this->makeRedirect('update',$post);
    }

    public function update_onSave($recordId)
    {
        $post = \Phyo\Articles\Models\Post::findOrFail($recordId);

        $input = post('Post');
        $post->title = $input['title'];
        $post->slug  = $input['slug'];
        $post->body  = $input['body'];
        $post->user_id = BackendAuth::getUser()->id;
        $post->save();



  //        $this->savePost($post);

        Flash::success("Updated!!");
        return back();

    }



    public function update_onDelete($recordId)
    {
        $post = \Phyo\Articles\Models\Post::find($recordId);
        $post->delete();
        Flash::success("Post deleted successfully");
        return $this->makeRedirect('delete', $post);
    }

    /**
     * @param $model
     * update for relactionship
     */
    public function formAfterDelete($model)
    {
        // Need
    }

    public function savePost($post)
    {

        $input = post('Post');
        $post->title = $input['title'];
        $post->slug  = $input['slug'];
        $post->body  = $input['body'];
        $post->user_id = BackendAuth::getUser()->id;
        $post->save();

        $tags_id = [];

        if ($input['tags']){
            $tags = $input['tags'];
            foreach ($tags as $tag){
                $tag_ref = \Phyo\Articles\Models\Tag::firstOrCreate(['name' => $tag ,'tag_slug' => $tag]);
                $tags_id = $tag_ref->id;
                $post->tags()->attach($tags_id);
            }


        }

        return $post;
    }
}
