<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

use App\Models\Order;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    private function currentCart(): Cart
    {
        return Cart::firstOrCreate(['user_id' => auth()->id()]);
    }

    public function add(Product $product)
    {
        $cart = $this->currentCart();

        $item = CartItem::firstOrCreate(
            ['cart_id' => $cart->id, 'product_id' => $product->id],
            ['quantity' => 0]
        );
        $item->increment('quantity');

        return back()->with('added', $product->name);
    }

    public function index()
    {
        [$cart, $subtotal, $shipping] = $this->buildCart();
    
        return view('cart.index', compact('cart', 'subtotal', 'shipping'));
    }

  public function checkout()
  {
    [$cart, $subtotal, $shipping] = $this->buildCart();


    return view('checkout.index', compact('cart', 'subtotal', 'shipping'));

  }  

    public function placeOrder(Request $request)
    {
        $data = $request->validate([
            'full_name' => 'required|string|max:100',
            'email'     => 'required|email|max:150',
            'phone'     => 'required|string|max:20',
            'area'      => 'required|string|max:150',
            'block'     => 'required|string|max:20',
            'street'    => 'required|string|max:150',
            'building'  => 'required|string|max:50',
            'floor'     => 'nullable|string|max:20',
            'apartment' => 'nullable|string|max:20',
            'paci'      => 'nullable|string|max:20',
            'notes'     => 'nullable|string|max:500',
        ]);

        [$cart, $subtotal, $shipping] = $this->buildCart();

        if (empty($cart)) {
            return redirect()->route('cart.index');
        }

        DB::transaction(function () use ($data, $cart, $subtotal, $shipping) {
            $order = Order::create([
                'user_id'  => auth()->id(),
                ...$data,
                'subtotal' => $subtotal,
                'shipping' => $shipping,
                'total'    => $subtotal + $shipping,
                
            ]);

            foreach ($cart as $item) {
                $order->items()->create([
                    'product_id' => $item['id'],
                    'name'       => $item['name'],
                    'price'      => $item['price'],
                    'quantity'   => $item['qty'],
                ]);
            }

            $this->currentCart()->items()->delete();
        });

        return redirect()->route('checkout');
    }



    private function buildCart(): array
    {
        $items = $this->currentCart()->items()->with('product')->get();
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

        $subtotal = collect($cart)->sum(fn ($item) => $item['price'] * $item['qty']);
        $shipping = $subtotal > 0 ? 150 : 0;

        return [$cart, $subtotal, $shipping];
    }

  

public function update(Request $request, $id)
{
    $request->Validate(['qty'=> 'required|integer|min:0|max:99']);

    $item = $this->currentCart()->items()->where('product_id', $id)->first();

    if ($item) {
        if ((int) $request->qty === 0){
            $item->delete();
        } else {
            $item->update(['quantity' => (int) $request->qty]);
}
    }

    return back();
} 

   
  




public function remove($id)
{
    $this->currentCart()->items()->where('product_id', $id)->delete();

    return back();
}




}