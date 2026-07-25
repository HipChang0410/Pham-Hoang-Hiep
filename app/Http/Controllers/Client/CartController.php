<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        $categories = Schema::hasTable('categories')
            ? Category::query()->where('status', 1)->orderBy('catename')->get()
            : collect();
        $brands = Schema::hasTable('brands')
            ? Brand::query()->where('status', 1)->orderBy('brandname')->get()
            : collect();

        return view('client.cart.index', compact('cart', 'categories', 'brands'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['nullable', 'integer', 'min:1'],
        ]);

        $product = Product::findOrFail($request->input('product_id'));
        $cart = session('cart', []);
        $quantity = max(1, (int) $request->input('quantity', 1));

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            $cart[$product->id] = [
                'product_id' => $product->id,
                'product_name' => $product->productname,
                'quantity' => $quantity,
                'price' => (float) $product->pricediscount ?: (float) $product->price,
            ];
        }

        session(['cart' => $cart]);

        return redirect()->back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng.');
    }

    public function checkout(Request $request)
    {
        $data = $request->validate([
            'fullname' => ['required', 'string', 'max:100'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
        ]);

        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống.');
        }

        return DB::transaction(function () use ($data, $cart) {
            $customer = Customer::create([
                'fullname' => $data['fullname'],
                'phone' => $data['phone'],
                'address' => $data['address'],
                'email' => $data['email'] ?? null,
            ]);

            $order = Order::create([
                'customer_id' => $customer->id,
                'total_amount' => 0,
                'status' => 'pending',
            ]);

            $total = 0;
            foreach ($cart as $item) {
                $product = Product::findOrFail($item['product_id']);
                $lineTotal = $item['quantity'] * ($item['price'] ?? ((float) $product->pricediscount ?: (float) $product->price));
                $total += $lineTotal;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'] ?? ((float) $product->pricediscount ?: (float) $product->price),
                ]);
            }

            $order->update(['total_amount' => $total]);
            session()->forget('cart');

            return redirect()->route('home')->with('success', 'Đặt hàng thành công.');
        });
    }
}
