<?php


namespace App\Http\Controllers\Shop\Admin\Add;


use App\DataObjects\Shop\SavePackObject;
use App\Entity\Shop\Category;
use App\Entity\Shop\Item;
use App\Exceptions\RuntimeException;
use App\Handlers\Shop\Admin\Add\PackHandler;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PackController extends Controller
{
    public function render(PackHandler $handler)
    {
        return new JsonResponse([
            'items' => array_map(function (Item $item) {
                return $item->__toArray();
            }, $handler->getItems()),
            'categories' => array_map(function (Category $category) {
                return $category->__toArray();
            }, $handler->getCategories()),
        ]);
    }

    public function add(Request $request, PackHandler $handler)
    {
        try {
            $this->validate($request, [
                'category' => 'integer|min:1|required',
                'price' => 'integer|min:1|required',
                'groups' => 'string|nullable',
                'name' => 'string|required',
                'image' => 'required|file|image|mimes:jpeg,bmp,png',
                'items' => 'array|required'
            ], [
                'category.required' => 'Вы не выбрали категорию!',
                'price.*' => 'Вы не указали цену!',
                'name.required' => 'Вы не указали название!',
                'image.required' => 'Вы не выбрали изображение!',
                'items.required' => 'Вы не выбрали итемы!'
            ]);

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

            $product = $handler->handle(new SavePackObject(
                $category,
                $items,
                $request->post('price'),
                $request->post('name'),
                $request->file('image'),
                $groups
            ));

            return new JsonResponse(['msg' => "Вы успешно создали набор {$product->getName()}"]);
        } catch (ValidationException $exception) {
            return new JsonResponse(['msg' => $exception->validator->getMessageBag()->first()]);
        }  catch (RuntimeException $exception) {
            return new JsonResponse(['msg' => $exception->getMessage()], 500);
        }
    }
}