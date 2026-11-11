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
      $validated = $request->validate([
          'full_name' => ['required', 'string', 'max:30'],
          'email' => ['required', 'email', 'max:30'],
          'phone' => ['required', 'string', 'max:20'],
          'area' => ['required', 'string', 'max:20'],
          'block' => ['required', 'string', 'max:20'],
          'street' => ['required', 'string', 'max:25'],
          'building' => ['required', 'string', 'max:23'],
          'floor' => ['nullable', 'string', 'max:34'],
          'apartment' => ['nullable', 'string', 'max:40'],
          'paci' => ['nullable', 'string', 'max:30'],
          'notes' => ['nullable', 'string', 'max:500'],
      ]);

      $order = DB::transaction(function () use ($request, $validated) {
          $cart = Cart::where('user_id', $request->user()->id)
              ->lockForUpdate()
              ->first();

          if (!$cart) {
              return null;
          }

          $cartItems = $cart->items()->lockForUpdate()->get();
          if ($cartItems->isEmpty()) {
              return null;
          }

          $products = Product::whereIn('id', $cartItems->pluck('product_id'))
              ->lockForUpdate()
              ->get()
              ->keyBy('id');

          if ($products->count() !== $cartItems->pluck('product_id')->unique()->count()) {
              abort(422, 'One or more products in your cart are unavailable.');
          }

          $subtotal = $cartItems->sum(
              fn ($item) => $products[$item->product_id]->price * $item->quantity
          );
          $shipping = $subtotal > 0 ? 150 : 0;

          $order = Order::create([
              'user_id' => $request->user()->id,
                            'name' => $validated['full_name'],
                            'email' => $validated['email'],
                            'phone' => $validated['phone'],
                            'shipping_address' => implode(', ', array_filter([
                                    $validated['area'],
                                    'Block ' . $validated['block'],
                                    'Street ' . $validated['street'],
                                    'Building ' . $validated['building'],
                                    isset($validated['floor']) ? 'Floor ' . $validated['floor'] : null,
                                    isset($validated['apartment']) ? 'Apartment ' . $validated['apartment'] : null,
                                    isset($validated['paci']) ? 'PACI ' . $validated['paci'] : null,
                            ])),
              'subtotal' => $subtotal,
              'shipping' => $shipping,
              'total' => $subtotal + $shipping,
          ]);

          foreach ($cartItems as $item) {
              $product = $products[$item->product_id];
              $order->items()->create([
                  'product_id' => $product->id,
                  'name' => $product->name,
                  'price' => $product->price,
                  'quantity' => $item->quantity,
              ]);
          }

          $cart->items()->delete();

          return $order;
      });

      if (!$order) {
          return redirect()->route('checkout')->with('error', 'Your cart is empty.');
      }

      return redirect()->route('checkout')->with('success', 'Your order has been placed successfully.');
  }


   public function store(CheckoutRequest $request)
   {
    
        checkout::create($request->validated());

        return redirect()->route('checkout.index');

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