<?php


namespace App\Http\Controllers\Shop\Admin\Add;


use App\DataObjects\Shop\ProductSaveObject;
use App\Entity\Shop\Category;
use App\Entity\Shop\Item;
use App\Exceptions\RuntimeException;
use App\Handlers\Shop\Admin\Add\OneHandler;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class OneController extends Controller
{
    public function render(OneHandler $handler)
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

    public function add(Request $request, OneHandler $handler)
    {
        try {
            $this->validate($request, [
                'category' => 'integer|min:1|required',
                'item' => 'integer|min:1|required',
                'amount' => 'integer|min:1|required',
                'price' => 'integer|min:1|required',
                'groups' => 'string|nullable',
                'name' => 'string|nullable',
                'image' => 'nullable|file|image|mimes:jpeg,bmp,png',
            ]);

            $category = $handler->getCategory((int) $request->post('category'));
            $item = $handler->getItem((int) $request->post('item'));

            $groups = $request->post('groups');
            if(!empty($groups)) {
                $groups = explode(',', str_replace(' ', '', $groups));
            } else {
                $groups = [];
            }

            $product = $handler->handle(new ProductSaveObject(
                $category,
                $item,
                (int) $request->post('amount'),
                (int) $request->post('price'),
                $groups,
                $request->post('name'),
                $request->file('image')
            ));

            return new JsonResponse(['msg' => 'Вы успешно создали товар', 'product' => $product->__toArray()]);
        } catch (ValidationException $exception) {
            return new JsonResponse(['msg' => $exception->validator->getMessageBag()->first()]);
        }  catch (RuntimeException $exception) {
            return new JsonResponse(['msg' => $exception->getMessage()], 500);
        }
    }
}