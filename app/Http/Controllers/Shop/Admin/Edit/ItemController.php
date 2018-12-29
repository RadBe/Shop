<?php


namespace App\Http\Controllers\Shop\Admin\Edit;


use App\DataObjects\Shop\ItemSaveObject;
use App\Entity\Shop\Type;
use App\Exceptions\RuntimeException;
use App\Exceptions\Shop\ItemNotFoundException;
use App\Handlers\Shop\Admin\Edit\ItemHandler;
use App\Http\Controllers\Controller;
use App\Services\Shop\ItemExtraValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ItemController extends Controller
{
    public function render(ItemHandler $handler, int $id)
    {
        try {
            return new JsonResponse([
                'types' => array_map(function (Type $type) {
                    return $type->__toArray();
                }, $handler->getTypes()),
                'item' => $handler->getItem($id)->__toArray()
            ]);
        } catch (ItemNotFoundException $exception) {
            return new JsonResponse(['msg' => $exception->getMessage()], 404);
        }
    }

    public function edit(Request $request, ItemHandler $handler, int $id)
    {
        try {
            $this->validate($request, [
                'type' => 'string|required',
                'name' => 'string|required',
                'description' => 'string|nullable',
                'image' => 'nullable|file|image|mimes:jpeg,bmp,png',
                'extra' => 'array|nullable'
            ]);

            $item = $handler->getItem($id);

            $type = $handler->getType($request->post('type'));

            (new ItemExtraValidator())->validate($type->getExtraArray(), (array) $request->post('extra'));

            $handler->handle(new ItemSaveObject(
                $type,
                $request->post('name'),
                $request->post('description'),
                $request->file('image'),
                (array) $request->post('extra')
            ), $item);

            return new JsonResponse([
                'msg' => "Вы успешно отредактировали итем {$item->getName()}",
                'item' => $item->__toArray()
            ]);

        } catch (ValidationException $exception) {
            return new JsonResponse(['msg' => $exception->validator->getMessageBag()->first()], 500);
        } catch (RuntimeException $exception) {
            return new JsonResponse(['msg' => $exception->getMessage()], 500);
        }
    }
}