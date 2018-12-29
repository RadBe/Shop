<?php


namespace App\Http\Controllers\Shop;


use App\Exceptions\RuntimeException;
use App\Exceptions\ServerNotEnabled;
use App\Exceptions\UnexpectedValueException;
use App\Handlers\Shop\BuyHandler;
use App\Http\Controllers\Controller;
use App\Services\Auth\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BuyController extends Controller
{
    public function buy(Request $request, BuyHandler $handler)
    {
        try {
            $this->validate($request, [
                'product' => 'integer|min:1|required',
                'amount' => 'integer|min:1|required'
            ]);

            $product = $handler->getProduct((int) $request->post('product'));

            if(!$product->getCategory()->getServer()->isEnabled()) {
                throw new ServerNotEnabled($product->getCategory()->getServer());
            }

            $po = $handler->handle($product, Auth::getUser(), (int) $request->post('amount'));

            return new JsonResponse([
                'money' => $po->getUser()->getMoney(),
                'msg' => "Вы успешно купили товар: " . $product->getProductName()
            ]);
        } catch (ValidationException $exception) {
            return new JsonResponse(['msg' => $exception->validator->getMessageBag()->first()], 500);
        } catch (RuntimeException | UnexpectedValueException $exception) {
            return new JsonResponse(['msg' => $exception->getMessage()], 500);
        }
    }
}