@extends('layouts/index2')

@section('container')

<section class="ftco-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mb-5 ftco-animate">
                <a href="{{asset('storage/'. $order->bukti_tf)}}" class="image-popup"><img src="{{asset('storage/'. $order->bukti_tf)}}" class="img-fluid" alt="Colorlib Template"></a>
            </div>
            <div class="col-lg-6 product-details pl-md-5 ftco-animate">

                @php
                $items = json_decode($order->items);
                $qty = json_decode($order->qty)
                @endphp
                {{-- @dd($qty) --}}
                @foreach ($qty as $jumlah)
                @endforeach
                @foreach ($items as $data)
                <h3 class="text-capitalize">{{\DB::table('products')->where('slug', $data)->value('product_name')}} <span>[{{$jumlah}}]</span></h3>
                @endforeach
                {{-- @dd($item) --}}
                <div class="rating d-flex">
                    <p class="text-left">
                        <a href="#" class="mr-2" style="color: #000;">{{\DB::table('products')->where('slug', $data)->value('stock')}} <span style="color: #bbb;">Stock Tersedia</span></a>
                    </p>
                </div>
                <p class="price"><span>Rp {{number_format($order->subtotal + $order->cost)}}</span> Total Biaya</p>
                <p></p>
                <div class="row mt-4">
                    <div class="w-100"></div>
                    <div class="col-md-12">
                        <h5 style="color: #000;">Data Order</h5>
                        <p class="text-capitalize">Nama Lengkap : <span>{{$order->nama_depan}} {{$order->nama_belakang}}</span></p>
                        <p class="text-capitalize">Nomor Telepon : <span>{{$order->telepon}}</span></p>
                        <p>Email : <span>{{$order->email}}</span></p>
                        <p>Provinsi: <span>{{\DB::table('provinces')->where('id', $order->provinsi)->value('title')}}</span></p>
                        <p>Kota: <span>{{\DB::table('cities')->where('id', $order->kota)->value('title')}}</span></p>
                        <p>Detail Alamat : <span>{{$order->alamat}}</span></p>
                        <p>Kurir : <span>{{\DB::table('couriers')->where('code', $order->kurir)->value('title')}}</span></p>
                        <p>Kurir : <span>Rp. {{number_format($order->cost)}}</span></p>
                        <p>Status : <span class="badge badge-info">{{$order->status}}</span></p>
                        {{-- @dd($order) --}}
                    </div>
                </div>
                <p><a href="{{url('kembali')}}" class="btn btn-black py-3 px-5">Kembali</a></p>
            </div>
        </div>
    </div>
</section>
@stop