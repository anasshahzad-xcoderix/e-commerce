<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
class CartController extends Controller
{
    public function add(Product $product)
    {
        $cart = session('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['qty']++;
        } else {
            $cart[$product->id] = [
                'id'    => $product->id,
                'name'  => $product->name,
                'price' => (float) $product->price,
                'image' => $product->image,
                'art'   => $product->art,
                'qty'   => 1,
            ];
        }

        session(['cart' => $cart]);

        return redirect()->route('checkout')->with('added', $product->name);
    }

    public function checkout()
    {
        $cart = session('cart', []);
        $subtotal = collect($cart)->sum(fn ($item) => $item['price'] * $item['qty']);
        $shipping = $subtotal > 0 ? 150 : 0;

        return view('checkout.index', compact('cart', 'subtotal', 'shipping'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(['qty' => 'required|integer|min:0|max:99']);

        $cart = session('cart', []);

        if (isset($cart[$id])) {
            if ((int) $request->qty === 0) {
                unset($cart[$id]);
            } else {
                $cart[$id]['qty'] = (int) $request->qty;
            }
        }

        session(['cart' => $cart]);

        return back();
    }

    public function remove($id)
    {
        $cart = session('cart', []);
        unset($cart[$id]);
        session(['cart' => $cart]);

        return back();
    }

    public function placeOrder(Request $request)
    {
        if (empty(session('cart', []))) {
            return redirect()->route('checkout')->with('error', 'Cart khali hai.');
        }

        $request->validate([
            'name'    => 'required|string|max:100',
            'phone'   => 'required|string|max:20',
            'address' => 'required|string|max:500',
        ], [
            'name.required'    => 'Naam zaroori hai.',
            'phone.required'   => 'Phone number zaroori hai.',
            'address.required' => 'Pata zaroori hai.',
        ]);

        // Demo: order abhi database mein save nahi hota
        session()->forget('cart');

        return redirect()->route('checkout')->with('ordered', true);
    }
}