<?php namespace Phyo\Articles\Models;

use Model;

/**
 * Tag Model
 */
class Tag extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'phyo_articles_tags';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['name','tag_slug'];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [];
    public $belongsToMany = [
        'posts' => ['Phyo\Articles\Models\Post','table' => 'phyo_articles_post_tag']
    ];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
}
