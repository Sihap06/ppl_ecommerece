<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use App\Product;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        return view('admin.index')->with(['user' => User::count(), 'products' => Product::count(), 'orders' => Order::count(), 'categories' => Category::count()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create')->with(['roles' => Role::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = new \App\User;

        $adminRole = Role::where('name', 'admin')->first();

        $data->name = $request->get('_name');
        $data->email = $request->get('_email');
        $data->address = $request->get('_address');
        $data->phone = $request->get('_phone');
        $data->password = \Hash::make($request->get('_password'));

        if ($request->hasFile('_avatar')) {
            $dir = 'avatars';
            $path = $request->file('_avatar')->store($dir, 'public');
            $data->avatar = $path;
        }

        $data->save();
        $data->roles()->attach($adminRole);

        return response()->json(['success' => 'Data berhasil disimpan']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = \App\User::find($id);

        return view('admin.users.show', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::user()->id == $id) {
            return redirect()->route('dashboard.index')->with('warning', 'You are not alllowed to edit yourself');
        }

        return view('admin.users.edit')->with(['user' => User::find($id), 'dashboard' => User::all(), 'roles' => Role::all()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = \App\User::find($id);

        \Validator::make($request->all(), [
            'name'      => 'required|min:5|max:100',
            'email'     => 'required|email',
            'address'   => 'required|min:10|max:200',
            'phone'     => 'required|digits_between:12,13'
        ])->validate();



        $user->roles()->sync($request->roles);

        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->address = $request->get('address');
        $user->phone = $request->get('phone');
        $new_avatar = $request->file('avatar');
        if ($new_avatar) {
            if ($user->avatar && file_exists(storage_path('app/public/' . $user->avatar))) {
                \Storage::delete('public/' . $user->avatar);
            }

            $new_product_path = $new_avatar->store('images_product', 'public');

            $user->avatar = $new_product_path;
        }

        $user->status = $request->get('status');

        $user->save();

        return redirect()->route('dashboard.edit', ['id' => $id])->with('success', 'User Succesfully updates');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if (Auth::user()->id == $id) {
            return redirect()->route('dashboard.index')->with('warning', 'You are not alllowed to delete yourself.');
        }

        User::destroy($request->hapus_id);
        Role::destroy($request->hapus_id);
        return redirect()->route('users.index')->with('success', 'User has been deleted.');
    }
}
