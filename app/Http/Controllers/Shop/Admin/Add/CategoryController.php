<?php


namespace App\Http\Controllers\Shop\Admin\Add;


use App\DataObjects\Shop\CategorySaveObject;
use App\Entity\Server;
use App\Exceptions\RuntimeException;
use App\Handlers\Shop\Admin\Add\CategoryHandler;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    public function render(CategoryHandler $handler)
    {
        return new JsonResponse([
            'servers' => array_map(function (Server $server) {
                return $server->__toArray();
            }, $handler->getServers())
        ]);
    }

    public function add(Request $request, CategoryHandler $handler)
    {
        try {
            $this->validate($request, [
                'server' => 'integer|min:1|required',
                'name' => 'string|min:1|required',
                'weight' => 'integer|min:0|required'
            ]);

            $server = $handler->getServer((int) $request->post('server'));

            $category = $handler->handle(new CategorySaveObject(
                $server,
                $request->post('name'),
                (int) $request->post('weight')
            ));

            return new JsonResponse([
                'msg' => "Вы успешно создали категорию {$category->getName()}",
                'category' => $category->__toArray()
            ]);
        } catch (ValidationException $exception) {
            return new JsonResponse(['msg' => $exception->validator->getMessageBag()->first()], 500);
        } catch (RuntimeException $exception) {
            return new JsonResponse(['msg' => $exception->getMessage()], 500);
        }
    }
}