<?php namespace Phyo\Articles;

use Backend;
use Phyo\Articles\Models\Post;
use System\Classes\PluginBase;

/**
 * articles Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'articles',
            'description' => 'Articles CRUD',
            'author'      => 'phyo',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {
        Post::extend(function ($model){
            $model->belongsTo['user'] = ['\Backend\Models\User'];
        });
    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return []; // Remove this line to activate

        return [
            'Phyo\Articles\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {

        return [
//            'phyo.articles.manage_post' => [
//                'tab' => 'articles',
//                'label' => 'Manage Post'
//            ],
            'phyo.articles.post_create' => [
                'tab' => 'articles',
                'label' => 'Create Articles'
            ],
            'phyo.articles.post_update' => [
                'tab' => 'articles',
                'label' => 'Update Articles'
            ],
            'phyo.articles.post_delete' => [
                'tab' => 'articles',
                'label' => 'Delete Articles'
            ]
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {

        return [
            'articles' => [
                'label'       => 'Articles',
                'url'         => Backend::url('phyo/articles/Post'),
                'icon'        => 'icon-leaf',
                'permissions' => ['phyo.articles.*'],
                'order'       => 500,

                'sideMenu' => [
                    'tags' => [
                        'label'       => 'Tags',
                        'url'         => Backend::url('phyo/articles/Tag'),
                        'icon'        => 'icon-paperclip',
                        'permissions' => ['phyo.articles.*'],
                        'order'       => 600,
                    ],
                ]
            ],
        ];
    }
}
