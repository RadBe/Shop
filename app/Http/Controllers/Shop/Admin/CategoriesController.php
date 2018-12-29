<?php


namespace App\Http\Controllers\Shop\Admin;


use App\Entity\Server;
use App\Entity\Shop\Category;
use App\Exceptions\Shop\CategoryNotFoundException;
use App\Handlers\Shop\Admin\CategoriesHandler;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class CategoriesController extends Controller
{
    public function render(CategoriesHandler $handler)
    {
        return new JsonResponse([
            'servers' => array_map(function (Server $server) {
                return $server->__toArray();
            }, $handler->getServers()),
            'categories' => array_map(function (Category $category) {
                return $category->__toArray();
            }, $handler->getCategories())
        ]);
    }

    public function delete(CategoriesHandler $handler, int $id)
    {
        try {
            $category = $handler->getCategory($id);

            $handler->delete($category);

            return new JsonResponse([
                'msg' =>
                    "Вы успешно удалили категорию {$category->getName()} с сервера {$category->getServer()->getName()}"
            ]);
        } catch (CategoryNotFoundException $exception) {
            return new JsonResponse(['msg' => $exception->getMessage()], 404);
        }
    }
}