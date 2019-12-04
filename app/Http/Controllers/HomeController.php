<?php

namespace App\Http\Controllers;

use App\Banner;
use App\Category;
use App\Product;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Testimoni;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories = Category::with('products')->get()->all();
        // $products = Product::inRandomOrder()->take(8)->get();
        // dd($categories);
        return view('home', compact(['categories']))->with(['banners' =>  Banner::all()]);
    }

    public function show($id)
    {
        $product = \App\Product::findOrFail($id);
        $recentProducts = \App\Product::where('id', '!=', $id)->inRandomOrder()->take(4)->get();
        return view('detailproduct', compact(['product', 'recentProducts']));
    }

    public function cart()
    {
        $user_id = Auth::user()->id;
        $orders = \App\Order::with('user')->with('products')->whereIn('user_id', [$user_id])->get();

        // dd($orders);
        return view('cart')->with('orders', $orders->all());
    }
    public function hapuscart($id)
    {
        // Order::deleted($id);
        $data = DB::table('orders')->where('id', '=', $id)->delete();
        // dd($data);
        return redirect('/cart');
    }
    public function kategori($id)
    {
        $category = \DB::table('category_product')->where('category_id', $id)->get();
        $cat = $category->all();
        $product = \App\Category::with('products')->where('id', $id)->get()->all();
        $products = $product[0];
        // dd($product[0]);
        return view('kategori', compact('products'))->with(['banners' => Banner::all(), 'categories' => Category::all()]);
    }

    public function shop(Request $request)
    {
        // dd($request->all());

        if ($request->has('cari')) {
            $products = \App\Product::where('product_name', 'LIKE', '%' . $request->cari . '%')->get();
            // dd($products);
        } else {
            $products = \App\Product::inRandomOrder()->take(8)->get();
            // dd($products);
        }
        return view('shop', compact('products'))->with(['banners' => Banner::all(), 'categories' => Category::all()]);
    }

    public function kembali()
    {
        return redirect('orders');
    }
    public function testi(Request $request)
    {
        $data = \App\Order::findOrFail($request->id);
        $slug = json_decode($data->items);

        for ($i = 0; $i < count($slug); $i++) {
            $product = \App\Product::where('slug', $slug[$i])->value('id');
            $new = new \App\Testimoni;
            $new->user_id = Auth::user()->id;
            $new->order_id = $request->get('id');
            $new->product_id = $product;
            $new->value = $request->get('range');
            $new->save();
        }
        return redirect('profile');
    }
}
