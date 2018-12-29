<?php


namespace App\Http\Controllers\Shop\Admin;


use App\Entity\Shop\Item;
use App\Entity\Shop\Type;
use App\Exceptions\Shop\ItemNotFoundException;
use App\Handlers\Shop\Admin\ItemsHandler;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class ItemsController extends Controller
{
    public function render(ItemsHandler $handler)
    {
        return new JsonResponse([
            'types' => array_map(function (Type $type) {
                return $type->__toArray();
            }, $handler->getTypes()),
            'items' => array_map(function (Item $item) {
                return $item->__toArray();
            }, $handler->getItems())
        ]);
    }

    public function delete(ItemsHandler $handler, int $id)
    {
        try {
            $item = $handler->getItem($id);

            $handler->delete($item);

            return new JsonResponse([
                'msg' => "Вы успешно удалили итем {$item->getName()}"
            ]);
        } catch (ItemNotFoundException $exception) {
            return new JsonResponse(['msg' => $exception->getMessage()], 404);
        }
    }
}