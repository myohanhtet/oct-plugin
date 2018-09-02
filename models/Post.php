<?php namespace Phyo\Articles\Models;


use Backend\Facades\BackendAuth;
use Backend\Models\User;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Model;

/**
 * Post Model
 */
class Post extends Model
{
    use ValidatesRequests;
    /**
     * @var string The database table used by the model.
     */
    public $table = 'phyo_articles_posts';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [
        'user' => User::class
    ];
    public $belongsToMany = [
        'tags' => ['Phyo\Articles\Models\Tag','table' => 'phyo_articles_post_tag']
    ];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    public function getUserIdOptions()
    {
        return \Backend\Models\User::lists('login','id');
    }

    public $rules =
        [
            'title' =>  'required',
            'public' => 'required'
        ];

    public static function savePost($post)
    {
        $input = post('Post');
        $post->title = $input['title'];
        $post->slug = $input['slug'];
        $post->body = $input['body'];
        $post->user_id = BackendAuth::getUser()->id;
        $post->save();

        $tags_id = [];
        if ($input['tags']){
            $tags = explode(',',$input['tags']);
            foreach ($tags as $tag){
                $tag_name = Tag::firstOrCreate(['name' => $tag ,'tag_slug' => $tag]);
                $tags_id = $tag_name->id;
            }
        }
        $post->tags()->sync($tags_id);

        return $post;
    }
}
