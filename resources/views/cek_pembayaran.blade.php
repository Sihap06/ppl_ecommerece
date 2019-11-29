@extends('layouts/index1')


@section('container')


<section class="ftco-section ftco-cart">
    <div class="container">
        <div class="row">
            <div class="col-md-12 ftco-animate">
                <div class="cart-list">
                    <table class="table">
                        <thead class="thead-primary">
                            <tr class="text-center">
                                <th>&nbsp;</th>
                                <th>Produk</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @dd($data) --}}
                            @foreach ($data as $item)
                            
                            <tr class="text-center">
                                <td class="product-remove"><a href="{{url('pembayaran', $item->id)}}"><span class="ion-ios-close"></span></a></td>
                                
                                <td class="product-name">
                                    <p>
                                        @php
                                        $items = json_decode($item->items);
                                        @endphp
                                        @foreach ($items as $product)
                                        
                                        {{\DB::table('products')->where('slug', $product)->value('product_name')}},
                                        
                                        @endforeach
                                    </p>
                                </td>
                                
                                <td class="price">
                                    @foreach (json_decode($item->qty) as $quantity)

                                    {{$quantity}},

                                    @endforeach
                                </td>
                                
                                <td class="total">
                                    Rp. {{number_format($item->subtotal + $item->cost)}}
                                </td>
                            </tr><!-- END TR-->
                            
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>


@stop