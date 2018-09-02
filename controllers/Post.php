<?php namespace Phyo\Articles\Controllers;

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
        $post = \Phyo\Articles\Models\Post::savePost($post);

        Flash::success('Post Saved Successfully');

        return $this->makeRedirect('update',$post);
    }

    public function update_onSave($recordId)
    {
        $post = \Phyo\Articles\Models\Post::findOrFail($recordId);
        if ($this->user->hasAccess('phyo.articles.post_update')){
            if ($this->user->id == $post->user_id ){
                $this->savePost($post);
                Flash::success("Post updated successfully");
                return back();
            }
        }
        Flash::error("No Permission!!");
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
}
