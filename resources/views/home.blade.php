@extends('layouts/index')

@section('container')

@include('layouts.header.home')

<section class="ftco-section" id="kategori">
    <div class="container">
        <div class="row no-gutters ftco-services">
            <div class="col-md-3 text-center d-flex align-self-stretch ftco-animate">
                <div class="media block-6 services mb-md-0 mb-4">
                    <a href="#home-section">
                        <div class="icon bg-color-1 active d-flex justify-content-center align-items-center mb-2">
                            <span class="flaticon-shipped"></span>
                        </div>
                    </a>
                    <div class="media-body">
                        <h3 class="heading">Top Page</h3>
                    </div>
                </div>      
            </div>
            <div class="col-md-3 text-center d-flex align-self-stretch ftco-animate">
                <div class="media block-6 services mb-md-0 mb-4">
                    <a href="#kategori">
                        <div class="icon bg-color-3 d-flex justify-content-center align-items-center mb-2">
                            <span class="flaticon-award"></span>
                        </div>
                    </a>
                    <div class="media-body">
                        <h3 class="heading">Kategori</h3>
                    </div>
                </div>      
            </div>
            <div class="col-md-3 text-center d-flex align-self-stretch ftco-animate">
                <div class="media block-6 services mb-md-0 mb-4">
                    <a href="#produk">
                        <div class="icon bg-color-2 d-flex justify-content-center align-items-center mb-2">
                            <span class="flaticon-diet"></span>
                        </div>
                    </a>
                    <div class="media-body">
                        <h3 class="heading">Produk</h3>
                    </div>
                </div>    
            </div>
            <div class="col-md-3 text-center d-flex align-self-stretch ftco-animate">
                <div class="media block-6 services mb-md-0 mb-4">
                    <a href="#support">
                        <div class="icon bg-color-4 d-flex justify-content-center align-items-center mb-2">
                            <span class="flaticon-customer-service"></span>
                        </div>
                    </a>
                    <div class="media-body">
                        <h3 class="heading">Bot Page</h3>
                    </div>
                </div>      
            </div>
        </div>
    </div>
</section>

<section class="ftco-section" id="produk">
    <div class="container">
        <div class="row justify-content-center mb-3 pb-3">
            <div class="col-md-12 heading-section text-center ftco-animate">
                <h2 class="mb-4">Produk Kami</h2>
                <p>Kopi yang kami produksi berasal langsung dari pegunungan yang sangat bagus untuk kopi, sehingga kopi yang kami hasilkan mempunayi kualitas dan rasa yang mantap</p>
            </div>
        </div>   		
    </div>
    <div class="container">
        <div class="row">
            @foreach ($products as $product)
            <div class="col-md-6 col-lg-3 ftco-animate">
                <div class="product">
                    <a href="{{url('/show', $product->id)}}" class="img-prod">
                        <img class="img-product img-fluid" src="{{asset('storage/'. $product->avatar)}}" alt="Colorlib Template">
                        <div class="overlay"></div>
                    </a>
                    <div class="text py-3 pb-4 px-3 text-center">
                        <div class="anjeeng">
                            <h3 class="product-name" href="#">{{$product->product_name}}</h3>
                        </div>
                        <div class="d-flex">
                            <div class="pricing">
                                <p class="price"><span class="price-sale">Rp. {{ number_format($product->price, 0)}}</span></p>
                            </div>
                        </div>
                        <div class="bottom-area d-flex px-3">
                            <div class="m-auto d-flex">
                                
                                <form action="{{url('show', $product->id)}}" method="get">
                                    <button type="submit" class="btn btn-primary mr-1"><i class="ion-ios-menu"></i></button>
                                </form>
                                {{-- @dd($code) --}}
                                <form action="{{route('cart.store')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$product->id}}">
                                    <input type="hidden" name="name" value="{{$product->product_name}}">
                                    <input type="hidden" name="price" value="{{$product->price}}">
                                    <input type="hidden" name="qty" value="1">
                                    @guest

                                    <button type="button" data-toggle="modal" data-target="#loginModal" class="btn btn-primary"><i class="ion-ios-cart"></i></button>
                                        
                                    @else 

                                    <button type="submit" class="btn btn-primary"><i class="ion-ios-cart"></i></button>

                                    @endguest
                                </form>       
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- <section class="ftco-section img" style="background-image: url(images/bg_3.jpg);">
    <div class="container">
        <div class="row justify-content-end">
            <div class="col-md-6 heading-section ftco-animate deal-of-the-day ftco-animate">
                <span class="subheading">Best Price For You</span>
                <h2 class="mb-4">Deal of the day</h2>
                <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia</p>
                <h3><a href="#">Spinach</a></h3>
                <span class="price">$10 <a href="#">now $5 only</a></span>
                <div id="timer" class="d-flex mt-5">
                    <div class="time" id="days"></div>
                    <div class="time pl-3" id="hours"></div>
                    <div class="time pl-3" id="minutes"></div>
                    <div class="time pl-3" id="seconds"></div>
                </div>
            </div>
        </div>   		
    </div>
</section> --}}

@endsection