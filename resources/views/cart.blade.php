@extends('layouts/index1')

@section('title', 'My Cart')

@section('container')

<section class="ftco-section ftco-cart">
  <div class="container">
    <div class="row cart-row">
      <div class="col-md-12 ftco-animate">
        <div>
          @if (session()->has('success'))
          <div class="alert alert-success">
            {{session()->get('success')}}
          </div>
          @endif
          
        </div>
        {{-- @dd($code) --}}
        
        <a href="{{route('belanja')}}" class="btn btn-primary mt-3 mb-3">Lanjutkan Belanja</a>

        @if (Cart::count() > 0)
        
        <div id="cart" class="cart-list"> 
          <table id="cart" class="table" >
            <thead class="thead-primary">
              <tr class="text-center">
                <th>&nbsp;</th>
                <th>Gambar</th>
                <th>Nama Produk</th>
                <th>Qty</th>
                <th>Harga</th>
              </tr>
            </thead>
            <tbody class="cart-item">
              
              @foreach (Cart::content() as $item)
              
              @php
                  // dd($item);
              @endphp

              <tr class="text-center">
                <td>
                  {{-- @php
                      $user_id = Auth::user()->id;
                  @endphp --}}
                  {{-- @dd($user_id) --}}
                  <form action="{{route('cart.destroy', $item->rowId)}}" method="POST"> 
                    @csrf
                    {{ method_field('DELETE')}}
                    <button type="submit" style="background-color: white; "><i class="fas fa-trash-alt"></i></button>
                  </form>
                </td>
                
                <td class="image-prod">
                  <img src="{{asset('storage/'. $item->model->avatar)}}" width="100" alt="">
                </td>
                
                <td class="product-name">
                  <a href="{{url('/show', $item->model->id)}}">
                  <h3>{{$item->model->product_name}}</h3>
                  </a>
                </td>
                <td>{{$item->qty}}</td>
                <td class="price">{{$item->model->price}}</td>
                
              </tr><!-- END TR-->
              
              @endforeach
              
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="row justify-content-end">
      <div class="col-lg-4 mt-5 cart-wrap ftco-animate">
        <div class="cart-total mb-3">
          <h3>Total Keranjang</h3>
          {{-- <p class="d-flex">
            <span>Subtotal</span>
            <span>Rp. {{Cart::subtotal()}}</span>
          </p> --}}
          <hr>
          <p class="d-flex">
            <span>Total</span>
            <span>Rp. {{number_format(Cart::total())}}</span>
          </p>
        </div>
        <p><a href="{{route('checkout.index')}}" class="btn btn-primary py-3 px-4">Proceed to Checkout</a></p>
      </div>
      
    </div>
    @else 
    
    <script>
      alert('keranjang kosong!');
      location = history.back();
    </script>
    
    @endif
  </div>
</section>

@endsection