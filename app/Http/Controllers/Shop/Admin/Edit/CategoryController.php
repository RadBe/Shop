<?php


namespace App\Http\Controllers\Shop\Admin\Edit;


use App\DataObjects\Shop\CategorySaveObject;
use App\Entity\Server;
use App\Exceptions\RuntimeException;
use App\Exceptions\Shop\CategoryNotFoundException;
use App\Handlers\Shop\Admin\Edit\CategoryHandler;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    public function render(CategoryHandler $handler, int $id)
    {
        try {
            //dd($handler->getCategory($id)->__toArray());
            return new JsonResponse([
                'servers' => array_map(function (Server $server) {
                    return $server->__toArray();
                }, $handler->getServers()),
                'category' => $handler->getCategory($id)->__toArray()
            ]);
        } catch (CategoryNotFoundException $exception) {
            return new JsonResponse(['msg' => $exception->getMessage()], 404);
        }
    }

    public function edit(Request $request, CategoryHandler $handler, int $id)
    {
        try {
            $this->validate($request, [
                'server' => 'integer|min:1|required',
                'name' => 'string|min:1|required',
                'weight' => 'integer|min:0|required'
            ]);

            $category = $handler->getCategory($id);
            $server = $handler->getServer((int) $request->post('server'));

            $handler->handle(new CategorySaveObject(
                $server,
                $request->post('name'),
                (int) $request->post('weight')
            ), $category);

            return new JsonResponse([
                'msg' => "Вы успешно изменили категорию {$category->getName()}",
                'category' => $category->__toArray()
            ]);
        } catch (ValidationException $exception) {
            return new JsonResponse(['msg' => $exception->validator->getMessageBag()->first()], 500);
        } catch (RuntimeException $exception) {
            return new JsonResponse(['msg' => $exception->getMessage()], 500);
        }
    }
}