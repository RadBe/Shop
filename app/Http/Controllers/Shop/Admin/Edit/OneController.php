<?php


namespace App\Http\Controllers\Shop\Admin\Edit;


use App\DataObjects\Shop\ProductSaveObject;
use App\Exceptions\RuntimeException;
use App\Exceptions\Shop\ProductNotFoundException;
use App\Handlers\Shop\Admin\Edit\OneHandler;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class OneController extends Controller
{
    public function render(OneHandler $handler, int $id)
    {
        try {
            $product = $handler->getProduct($id);

            return new JsonResponse(['product' => $product->__toArray()]);
        } catch (ProductNotFoundException $exception) {
            return new JsonResponse(['msg' => $exception->getMessage()], 404);
        }
    }

    public function edit(Request $request, OneHandler $handler, int $id)
    {
        try {
            $this->validate($request, [
                'category' => 'integer|min:1|required',
                'item' => 'integer|min:1|required',
                'amount' => 'integer|min:1|required',
                'price' => 'integer|min:1|required',
                'groups' => 'string|nullable',
                'name' => 'string|min:1|nullable',
                'image' => 'nullable|file|image|mimes:jpeg,bmp,png',
                'delete_picture' => 'nullable|boolean',
            ]);

            $product = $handler->getProduct($id);

            $category = $handler->getCategory((int) $request->post('category'));
            $item = $handler->getItem((int) $request->post('item'));

            $groups = $request->post('groups');
            if(!empty($groups)) {
                $groups = explode(',', str_replace(' ', '', $groups));
            } else {
                $groups = [];
            }

            $deletePicture = $request->post('delete_picture', false);

            $handler->handle(new ProductSaveObject(
                $category,
                $item,
                (int) $request->post('amount'),
                (int) $request->post('price'),
                $groups,
                $request->post('name', null),
                $request->file('image')
            ), $product, $deletePicture);

            return new JsonResponse([
                'msg' => "Вы успешно изменили товар {$product->getName()}",
                'product' => $product->__toArray()
            ]);
        } catch (ValidationException $exception) {
            return new JsonResponse(['msg' => $exception->validator->getMessageBag()->first()]);
        }  catch (RuntimeException $exception) {
            return new JsonResponse(['msg' => $exception->getMessage()], 500);
        }
    }
}