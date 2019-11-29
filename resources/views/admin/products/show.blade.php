@extends('admin.master')

@section('content')

<div class="container">
    <h2 class="text-center">Detail {{$product->product_name}}</h2>
    <div class="row justify-content-center">
        <div class="col-lg-5 p-5">
            @if ($product->avatar)
            <img src="{{asset('storage/'. $product->avatar)}}" width="400px" alt="">
            @else
            No Avatar
            @endif
        </div>
        <div class="col-lg-5 p-5">
            <div class="card mb-4 py-3 border-left-success">
                <div class="card-body">
                    <b>Nama Produk :</b>
                    {{$product->product_name}}
                    
                    <br>
                    <b>Harga :</b>
                    Rp. {{number_format($product->price, 0)}}
                    
                    <br>
                    <b>Kategori :</b>
                    {{implode(', ', $product->categories()->get()->pluck('name')->toArray())}}
                    
                    <br>
                    <b>Deskripsi :</b>
                    {{$product->description}}
                    
                    <br>
                    <b>Stock :</b>
                    {{$product->stock}}
                    
                    
                </div>
            </div>
        </div>            
    </div>
</div>

@endsection