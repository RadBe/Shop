<?php


namespace App\Http\Controllers\Shop\Admin\Edit;


use App\DataObjects\Shop\SavePackObject;
use App\Exceptions\RuntimeException;
use App\Handlers\Shop\Admin\Edit\PackHandler;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PackController extends Controller
{
    public function edit(Request $request, PackHandler $handler, int $id)
    {
        try {
            $this->validate($request, [
                'category' => 'integer|min:1|required',
                'price' => 'integer|min:1|required',
                'groups' => 'string|nullable',
                'name' => 'string|required',
                'image' => 'nullable|file|image|mimes:jpeg,bmp,png',
                'items' => 'array|required'
            ], [
                'category.required' => 'Вы не выбрали категорию!',
                'price.*' => 'Вы не указали цену!',
                'name.required' => 'Вы не указали название!',
                'items.required' => 'Вы не выбрали итемы!'
            ]);

            $product = $handler->getProduct($id);

            $category = $handler->getCategory((int) $request->post('category'));

            $groups = $request->post('groups');
            if(!empty($groups)) {
                $groups = explode(',', str_replace(' ', '', $groups));
            } else {
                $groups = [];
            }

            $items = [];

            foreach ($request->post('items') as $itemId => $itemAmount)
            {
                $items[] = [$handler->getItem((int) $itemId), $itemAmount];
            }

            if(count($items) < 1) {
                throw new RuntimeException('Вы не выбрали итемы для набора!');
            }

            $handler->handle(new SavePackObject(
                $category,
                $items,
                $request->post('price'),
                $request->post('name'),
                $request->file('image'),
                $groups
            ), $product);

            return new JsonResponse(['msg' => "Вы успешно изменили набор {$product->getName()}"]);
        } catch (ValidationException $exception) {
            return new JsonResponse(['msg' => $exception->validator->getMessageBag()->first()]);
        }  catch (RuntimeException $exception) {
            return new JsonResponse(['msg' => $exception->getMessage()], 500);
        }
    }
}