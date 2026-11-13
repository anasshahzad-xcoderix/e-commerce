<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\Cart;
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

        $added = DB::transaction(function () use ($cart, $product) {
            $cart = Cart::whereKey($cart->id)->lockForUpdate()->firstOrFail();

            if ($cart->items()->where('product_id', $product->id)->exists()) {
                return false;
            }

            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => 1,
            ]);

            return true;
        });

        $cartCount = $this->currentCart()->items()->sum('quantity');

        if (!$added) {
            $message = $product->name . ' is already in your cart.';

            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $message,
                    'count' => $cartCount,
                ]);
            }

            return back()->with('already_in_cart', $product->name);
        }

        $message = $product->name . ' added to cart.';

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'count' => $cartCount,
            ]);
        }

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
    
    return view('checout.index' , compact('cart', 'subtotal' , 'shipping'));
 

}

  public function store(CheckoutRequest $request)
  {
      $validated = $request->validated();

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
    $request->validate(['qty' => 'required|integer|min:0|max:99']);

    $item = $this->currentCart()->items()->where('product_id', $id)->first();

    if (!$item) {
        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Item not found in cart.',
                'count' => $this->currentCart()->items()->sum('quantity'),
            ]);
        }

        return back();
    }

    $qty = (int) $request->qty;

    if ($qty === 0) {
            $item->delete();
        $qty = 0;
        } else {
        $item->update(['quantity' => $qty]);
    }

    $product = Product::find($id);
    $subtotal = $this->currentCart()->items()->with('product')->get()->sum(
        fn ($cartItem) => ($cartItem->product?->price ?? 0) * $cartItem->quantity
    );
    $shipping = $subtotal > 0 ? 150 : 0;
    $count = $this->currentCart()->items()->sum('quantity');

    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'message' => 'Cart updated.',
            'count' => $count,
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'total' => $subtotal + $shipping,
            'item' => [
                'id' => $id,
                'qty' => $qty,
                'line_total' => $product ? ($product->price * $qty) : 0,
            ],
        ]);
    }

    return back();
}

public function remove(Request $request, $id)
{
    $this->currentCart()->items()->where('product_id', $id)->delete();

    if ($request->ajax()) {
        $subtotal = $this->currentCart()->items()->with('product')->get()->sum(
            fn ($item) => ($item->product?->price ?? 0) * $item->quantity
        );
        $shipping = $subtotal > 0 ? 150 : 0;

        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart.',
            'count' => $this->currentCart()->items()->sum('quantity'),
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'total' => $subtotal + $shipping,
            'removed' => true,
        ]);
    }

    return back();
}


}

