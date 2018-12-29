<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/


/* @var \Laravel\Lumen\Routing\Router $router*/
$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('servers', 'ServersController@render');

$router->group(['namespace' => 'Shop', 'prefix' => 'shop'], function (\Laravel\Lumen\Routing\Router $router) {
    $router->get('/', 'ListController@render');
    $router->get('/load_products', 'ListController@loadProducts');

    $router->post('/buy', 'BuyController@buy');

    $router->group(['namespace' => 'Admin', 'prefix' => 'admin'], function (\Laravel\Lumen\Routing\Router $router) {

        $router->get('products', 'ProductsController@render');
        $router->get('product_add/one', 'Add\OneController@render');
        $router->post('product_add/one', 'Add\OneController@add');
        $router->get('product_add/pack', 'Add\PackController@render');
        $router->post('product_add/pack', 'Add\PackController@add');
        $router->get('product_edit/{id:[0-9]+}', 'Edit\OneController@render');
        $router->post('product_edit/one/{id:[0-9]+}', 'Edit\OneController@edit');
        $router->post('product_edit/pack/{id:[0-9]+}', 'Edit\PackController@edit');

        $router->get('items', 'ItemsController@render');
        $router->get('item_add', 'Add\ItemController@render');
        $router->post('item_add', 'Add\ItemController@add');
        $router->get('item_edit/{id:[0-9]+}', 'Edit\ItemController@render'); //TODO: вроде эти штуки не нужны, разве что отдельной ссылкой на страничку
        $router->post('item_edit/{id:[0-9]+}', 'Edit\ItemController@edit');
        $router->post('item_delete/{id:[0-9]+}', 'ItemsController@delete');

        $router->get('categories', 'CategoriesController@render');
        $router->get('category_add', 'Add\CategoryController@render');
        $router->post('category_add', 'Add\CategoryController@add');
        $router->get('category_edit/{id:[0-9]+}', 'Edit\CategoryController@render');
        $router->post('category_edit/{id:[0-9]+}', 'Edit\CategoryController@edit');
        $router->post('category_delete/{id:[0-9]+}', 'CategoriesController@delete');
    });
});
