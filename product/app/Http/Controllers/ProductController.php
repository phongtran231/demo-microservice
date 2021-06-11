<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    protected $product;
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'name' => 'required',
                'price' => 'required|numeric',
            ]);
            $this->product->fill($request->input())->save();
            return response()->json([
                'data' => $this->product,
                'status' => Response::HTTP_OK,
            ]);
        } catch (ValidationException $e) {
            return response()->json($e->validator->getMessageBag(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function listProduct()
    {
        return response()->json([
            'data' => $this->product->get(),
        ]);
    }
}
