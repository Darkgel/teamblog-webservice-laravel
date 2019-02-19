<?php
/**
 * Created by PhpStorm.
 * User: Darkgel
 * Date: 2018/12/29
 * Time: 15:38
 */

use Dingo\Api\Routing\Router;

/** @var Dingo\Api\Routing\Router $api*/
$api->version('v1', ['namespace' => 'App\Api\Controllers\V1', 'middleware' => ['api.common']], function (Router $api) {
    $api->group(['namespace' => 'Blog', 'prefix' => 'blog'], function (Router $api){
        $api->group(['prefix' => 'articles'], function (Router $api){
            $api->get('{id}', 'ArticleController@detail');
            $api->get('/', 'ArticleController@index');
            $api->post('/', 'ArticleController@save');
            $api->delete('{id}', 'ArticleController@delete');
        });

        $api->group(['prefix' => 'tags'], function (Router $api){
            $api->get('{id}', 'TagController@detail');
            $api->get('/', 'TagController@index');
            $api->post('/', 'TagController@create');
            $api->put('{id}', 'TagController@update');
            $api->delete('{id}', 'TagController@delete');
            $api->get('similarity/name/{tagName?}', 'TagController@getSimilarTagsByTagName');
        });
    });
});
