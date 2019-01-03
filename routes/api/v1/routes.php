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
        $api->group(['prefix' => 'article'], function (Router $api){
            $api->get('{id}', 'ArticleController@detail');
        });

        $api->group(['prefix' => 'tag'], function (Router $api){
            $api->get('{id}', 'TagController@detail');
        });
    });
});
