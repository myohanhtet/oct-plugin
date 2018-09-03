<?php namespace Phyo\Articles\Models;


use Backend\Facades\BackendAuth;
use Backend\Models\User;
use http\Env\Request;
use Illuminate\Support\Facades\Input;
use Model;


/**
 * Post Model
 */
class Post extends Model
{
    /**
     * @var array Attribute names to encode and decode using JSON.
     */
    protected $jsonable = ['data'];
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

    /**
     * Validation rules
     */
    public $rules = [
        'title' => 'required',
        'body' => 'required'
    ];


}
