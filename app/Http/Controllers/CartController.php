<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Product $product)
    {
        $item = CartItem::firstOrCreate(
            ['user_id' => auth()->id(), 'product_id' => $product->id],
            ['quantity' => 0]
        );
        $item->increment('quantity');

        return back()->with('added', $product->name);
    }

    public function index()
    {
        [$cart, $subtotal, $shipping] = $this->buildCart();

        return view('cart.index', 
        compact('cart',
         'subtotal', 
         'shipping'));
    }

    

    private function 
    buildCart(): array
    {
        $items = CartItem::with('product')
        ->where('user_id', auth
        ()->id())->get();

        $cart = $items->mapWithKeys(fn ($i) => [
            $i->product_id => [
                'id'    => $i->product_id,
                'name'  => $i->product->name,
                'price' => (float) $i->product->price,
                'image' => $i->product->image,
                'art'   => $i->product->art,
                'qty'   => $i->quantity,
            ],
        ])->all();

        $subtotal = collect($cart)->sum(fn 
        ($item) => $item['price'] * $item['qty']);
        $shipping =
         $subtotal > 0 ? 150 : 0;

        return [$cart, $subtotal, $shipping];
    }

    public function 
    update(Request $request, $id)
    {
        $request->validate
        (['qty' => 'required|integer|min:0|max:99']);

        $item = CartItem::where('user_id', auth()->
        id())->where
        ('product_id', $id)->first();

        if ($item) {
            if ((int) $request->qty === 0) {
                $item->delete();
            } else {
                $item->update(['quantity' => 
                (int) $request->qty]);
            }
        }

        return back();
    }

    public function remove($id)
    {
        CartItem::where('user_id', auth()->id())->where
        ('product_id', $id)
        ->delete();

        return back();
    }

   
}