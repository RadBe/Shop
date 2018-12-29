<?php


namespace App\Http\Controllers\Shop\Admin\Add;


use App\DataObjects\Shop\ItemSaveObject;
use App\Entity\Shop\Type;
use App\Exceptions\RuntimeException;
use App\Handlers\Shop\Admin\Add\ItemHandler;
use App\Http\Controllers\Controller;
use App\Services\Shop\ItemExtraValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ItemController extends Controller
{
    public function render(ItemHandler $handler)
    {
        return new JsonResponse([
            'types' => array_map(function (Type $type) {
                return $type->__toArray();
            }, $handler->getTypes())
        ]);
    }

    public function add(Request $request, ItemHandler $handler)
    {
        try {
            $this->validate($request, [
                'type' => 'string|required',
                'name' => 'string|required',
                'description' => 'string|nullable',
                'image' => 'file|image|mimes:jpeg,bmp,png',
                'extra' => 'array|nullable'
            ]);

            $type = $handler->getType($request->post('type'));

            (new ItemExtraValidator())->validate($type->getExtraArray(), (array) $request->post('extra'));

            $item = $handler->handle(new ItemSaveObject(
                $type,
                $request->post('name'),
                $request->post('description'),
                $request->file('image'),
                (array) $request->post('extra')
            ));

            return new JsonResponse([
                'msg' => "Вы успешно создали итем {$item->getName()}",
                'item' => $item->__toArray()
            ]);
        } catch (ValidationException $exception) {
            return new JsonResponse(['msg' => $exception->validator->getMessageBag()->first()], 500);
        } catch (RuntimeException $exception) {
            return new JsonResponse(['msg' => $exception->getMessage()], 500);
        }
    }
}