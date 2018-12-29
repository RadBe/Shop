<?php


namespace App\Http\Controllers\Shop;


use App\Entity\Shop\Category;
use App\Entity\Shop\Product;
use App\Exceptions\ServerNotFoundException;
use App\Handlers\Shop\ListHandler;
use App\Http\Controllers\Controller;
use App\Services\Auth\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class ListController extends Controller
{
    public function render(ListHandler $handler, Request $request)
    {
        try {
            $this->validate($request, [
                'server' => 'required|integer|min:1',
                'category' => 'integer|min:1|nullable',
                'name' => 'string|nullable',
                'page' => 'integer|min:1|nullable',
            ]);

            $search = [
                'category' => empty(trim($request->get('category'))) ? null : $request->get('category'),
                'name' => empty(trim($request->get('name'))) ? null : $request->get('name')
            ];

            $page = $request->get('page', 1);
            if($page < 1) {
                $page = 1;
            }

            $server = $handler->getServer((int) $request->get('server'));
            $search['server'] = $server;

            $products = $handler->getProducts($search, $page);
            $categories = $handler->getCategories($server);

            return new JsonResponse([
                'user' => Auth::getUser()->__toArray(),
                'products' => array_map(function (Product $product) {
                    return $product->__toArray();
                }, $products->all()),
                'categories' => array_map(function (Category $category) {
                    return $category->__toArray();
                }, $categories),
                'page' => $page,
                'countPages' => $products->lastPage(),
            ]);
        } catch (ValidationException $exception) {
            return new JsonResponse(['msg' => $exception->validator->getMessageBag()->first()], Response::HTTP_FORBIDDEN);
        } catch (ServerNotFoundException $exception) {
            return new JsonResponse(['msg' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function loadProducts(ListHandler $handler, Request $request)
    {
        try {
            $this->validate($request, [
                'category' => 'integer|min:1|nullable',
                'name' => 'string|nullable',
                'page' => 'integer|min:1|nullable',
            ]);

            $search = [
                'category' => empty(trim($request->get('category'))) ? null : $request->get('category'),
                'name' => empty(trim($request->get('name'))) ? null : $request->get('name')
            ];

            $page = $request->get('page', 1);
            if($page < 1) {
                $page = 1;
            }

            $server = $handler->getServer((int) $request->get('server'));
            $search['server'] = $server;

            $products = $handler->getProducts($search, $page);

            return response()->json([
                'products' => array_map(function (Product $product) {
                    return $product->__toArray();
                }, $products->all()),
                'page' => $page,
                'countPages' => $products->lastPage(),
            ]);
        } catch (ValidationException $exception) {
            return new JsonResponse(['msg' => $exception->validator->getMessageBag()->first()], Response::HTTP_FORBIDDEN);
        } catch (ServerNotFoundException $exception) {
            return new JsonResponse(['msg' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}