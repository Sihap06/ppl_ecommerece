@extends('layouts.index1')

@section('container')

@php
$provinces = \DB::table('provinces')->pluck('title', 'province_id');
@endphp

<section class="ftco-section">
    <div class="container">
        <div class="mb-5">
            <button class="btn btn-success tablink" onclick="openPage('profile', this, '#82ae46', '#fff')">Profile</button>
            <button class="btn btn-success tablink" id="defaultOpen" onclick="openPage('pembelian', this, '#82ae46' , '#fff')">Transaksi</button>
        </div>
        <div class="tabcontent" id="profile">
            <div class="row justify-content-center">
                
                <div class="card align-items-center p-3 col-lg-6 mb-5 ftco-animate">
                    @if (Auth::user()->avatar)
                    
                    <a href="{{asset('storage/'. Auth::user()->avatar)}}" class="image-popup"><img width="400px" src="{{asset('storage/'. Auth::user()->avatar)}}" class="align-content-center img-fluid" alt="Avatar"></a>
                    
                    @else
                    
                    <a href="images/default_avatar.png" class="image-popup"><img width="400px" src="images/default_avatar.png" class="img-fluid" alt="Colorlib Template"></a>
                    
                    @endif
                    <br>
                    <button data-toggle="modal" data-id="{{Auth::user()->id}}" data-target="#fotoModal" class="btn btn-outline-success mt-5">Ganti Foto</button>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="card p-3 align-items-center col-lg-6 pl-md-5 ftco-animate">
                    <h5 class="text-capitalize">{{Auth::user()->name}}</h5>
                    <p><span>{{Auth::user()->email}}</span></p>
                    <p><span>{{DB::table('provinces')->where('province_id', Auth::user()->province_id)->value('title')}} - {{DB::table('cities')->where('city_id', Auth::user()->city_id)->value('title')}}</span></p>
                    <p><span>{{Auth::user()->phone}}</span></p>
                    <p class="text-capitalize"><span>{{Auth::user()->address}}</span></p>
                    <p><a href="#" data-id="{{Auth::user()->id}}" data-name="{{Auth::user()->name}}" data-email="{{Auth::user()->email}}" data-phone="{{Auth::user()->phone}}" data-address="{{Auth::user()->address}}" data-toggle="modal" data-target="#dataModal" class="btn btn-outline-success">Edit Profile</a></p>
                </div>
            </div>
        </div>
        
        <div class="tabcontent" id="pembelian">
            <div class="row justify-content-center">
                <div id="cart" class="col-md-10 cart-list col-lg-10">
                    <table class="table align-items-center card table-borderless">
                        <thead class="thead-inverse">
                            <tr>
                                <th>
                                    <button onclick="nextPage('dikonfirmasi', this, '#82ae46', '#000')" id="defaultBuka" class="btn btn-light tabnext">Menunggu Konfirmasi</button>
                                </th>
                                <th>
                                    <button onclick="nextPage('diproses', this, '#82ae46', '#000')" class="btn btn-light tabnext">Pesanan Diproses</button>
                                </th>
                                <th>
                                    <button onclick="nextPage('dikirim', this, '#82ae46', '#000')" class="btn btn-light tabnext">Pesanan Dikirim</button>
                                </th>
                                <th>
                                    <button onclick="nextPage('selesai', this, '#82ae46', '#000')" class="btn btn-light tabnext">Pesanan Selesai</button>
                                </th>
                            </tr>
                            
                        </thead>
                        <tbody>
                            <tr>
                                <td class="">
                                    <div id="dikonfirmasi" class="tabtransaksi align-items-start">
                                        <div class="row justify-content-center">
                                            <div class="col-md-10">
                                                <div class="cart-list">
                                                    <table class="table">
                                                        <thead class="thead-primary">
                                                            <tr class="text-center">
                                                                <th style="width: 25%;">Product List</th>
                                                                <th style="width: 25%;">Quantity</th>
                                                                <th style="width: 25%;">Total</th>
                                                                <th style="width: 25%;">Tanggl</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                            $data = \DB::table('orders')->where(['user_id' => Auth::user()->id, 'status' => 'booked'])->get()->all();
                                                            // dd($data);
                                                            @endphp
                                                            @foreach ($data as $item)
                                                            
                                                            <tr class="text-center">
                                                                <td class="product-name text-capitalize">
                                                                    @foreach (json_decode($item->items) as $product)
                                                                    {{\DB::table('products')->where('slug', $product)->value('product_name')}},
                                                                    @endforeach
                                                                </td>
                                                                
                                                                <td class="quantity">
                                                                    @foreach (json_decode($item->qty) as $qty)
                                                                    {{$qty}},
                                                                    @endforeach
                                                                </td>
                                                                
                                                                <td class="total">
                                                                    Rp {{number_format($item->subtotal + $item->cost)}}
                                                                </td>
                                                                <td class="total">
                                                                    {{date('d-m-Y', strtotime($item->created_at))}}
                                                                </td>
                                                            </tr><!-- END TR-->
                                                            @endforeach
                                                            
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="diproses" class="tabtransaksi align-items-start">
                                        <div class="row justify-content-center">
                                            <div class="col-md-10">
                                                <div class="cart-list">
                                                    <table class="table">
                                                        <thead class="thead-primary">
                                                            <tr class="text-center">
                                                                <th style="width: 25%;">Product List</th>
                                                                <th style="width: 25%;">Quantity</th>
                                                                <th style="width: 25%;">Total</th>
                                                                <th style="width: 25%;">Tanggl</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                            $data = \DB::table('orders')->where(['user_id' => Auth::user()->id, 'status' => 'verifikasi'])->get()->all();
                                                            // dd($data);
                                                            @endphp
                                                            @foreach ($data as $item)
                                                            
                                                            <tr class="text-center">
                                                                <td class="product-name text-capitalize">
                                                                    @foreach (json_decode($item->items) as $product)
                                                                    {{\DB::table('products')->where('slug', $product)->value('product_name')}},
                                                                    @endforeach
                                                                </td>
                                                                
                                                                <td class="quantity">
                                                                    @foreach (json_decode($item->qty) as $qty)
                                                                    {{$qty}},
                                                                    @endforeach
                                                                </td>
                                                                
                                                                <td class="total">
                                                                    Rp {{number_format($item->subtotal + $item->cost)}}
                                                                </td>
                                                                <td class="total">
                                                                    {{date('d-m-Y', strtotime($item->updated_at))}}
                                                                </td>
                                                            </tr><!-- END TR-->
                                                            @endforeach
                                                            
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="dikirim" class="tabtransaksi align-items-start">
                                        <div class="row justify-content-center">
                                            <div class="col-md-10">
                                                <div class="cart-list">
                                                    <table class="table">
                                                        <thead class="thead-primary">
                                                            <tr class="text-center">
                                                                <th style="width: 25%;">Product List</th>
                                                                <th style="width: 25%;">Quantity</th>
                                                                <th style="width: 25%;">Total</th>
                                                                <th style="width: 25%;">Tanggl</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                            $data = \DB::table('orders')->where(['user_id' => Auth::user()->id, 'status' => 'proses'])->get()->all();
                                                            // dd($data);
                                                            @endphp
                                                            @foreach ($data as $item)
                                                            
                                                            <tr class="text-center">
                                                                <td class="product-name text-capitalize">
                                                                    @foreach (json_decode($item->items) as $product)
                                                                    {{\DB::table('products')->where('slug', $product)->value('product_name')}},
                                                                    @endforeach
                                                                </td>
                                                                
                                                                <td class="quantity">
                                                                    @foreach (json_decode($item->qty) as $qty)
                                                                    {{$qty}},
                                                                    @endforeach
                                                                </td>
                                                                
                                                                <td class="total">
                                                                    Rp {{number_format($item->subtotal + $item->cost)}}
                                                                </td>
                                                                <td class="total">
                                                                    {{date('d-m-Y', strtotime($item->updated_at))}}
                                                                </td>
                                                            </tr><!-- END TR-->
                                                            @endforeach
                                                            
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="selesai" class="tabtransaksi align-items-start">
                                        <div class="row justify-content-center">
                                            <div class="col-md-10">
                                                <div class="cart-list">
                                                    <table class="table">
                                                        <thead class="thead-primary">
                                                            <tr class="text-center">
                                                                <th style="width: 25%;">Product List</th>
                                                                <th style="width: 25%;">Quantity</th>
                                                                <th style="width: 25%;">Total</th>
                                                                <th style="width: 25%;">Tanggl</th>
                                                                <th style="width: 25%;">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                            $data = \DB::table('orders')->where(['user_id' => Auth::user()->id, 'status' => 'selesai'])->get()->all();
                                                            // dd($data);
                                                            @endphp
                                                            @foreach ($data as $item)
                                                            
                                                            <tr class="text-center">
                                                                <td class="product-name text-capitalize">
                                                                    @foreach (json_decode($item->items) as $product)
                                                                    {{\DB::table('products')->where('slug', $product)->value('product_name')}},
                                                                    @endforeach
                                                                </td>
                                                                
                                                                <td class="quantity">
                                                                    @foreach (json_decode($item->qty) as $qty)
                                                                    {{$qty}},
                                                                    @endforeach
                                                                </td>
                                                                
                                                                <td class="total">
                                                                    Rp {{number_format($item->subtotal + $item->cost)}}
                                                                </td>
                                                                <td class="total">
                                                                    {{date('d-m-Y', strtotime($item->created_at))}}
                                                                </td>
                                                                <td>
                                                                    @php
                                                                        $data =count(\DB::table('testimoni')->where('order_id', $item->id)->get());
                                                                        var_dump($data); 
                                                                    @endphp
                                                                    @if($data == 0)
                                                                    <button data-id="{{$item->id}}" data-product="{{$item->items}}" data-toggle="modal" data-target="#ratingModal" class="btn btn-primary">Rating</button>
                                                                    @endif
                                                                </td>
                                                            </tr><!-- END TR-->
                                                            @endforeach 
                                                            
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
</div> 


<!-- Modal -->
<div class="modal fade" id="ratingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Rating</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
                <form method="POST" action="{{ url('testi') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="w3-half">
                        <div class="custom-control custom-radio mt-3">
                            <p>Tingkat kepuasan:</p>
                            <input type="range" name="range" class="custom-range">
                            <input type="hidden" name="id" id="id">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="fotoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Ganti Foto Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ url('gantiFoto') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <img width="100"class="img-circle" id="uploadPreview"/> <br>
                        
                    </div>
                    
                    <div class="form-group">
                        <input type="file" style="border-radius: 5px; font-size: 15px" name="gambar" class="form-control" id="uploadImage" onchange="PreviewImage();" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="dataModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="user" action="{{url('editProfile')}}" enctype="multipart/form-data" method="POST">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <input value="{{old('name')}}" type="text" name="name" class="form-control form-control-user @error('name') is-invalid @enderror" id="name" placeholder="Username">
                        @error('name') <div class="invalid-feedback">{{$message}}</div> @enderror
                    </div>
                    <div class="form-group">
                        <input value="{{old('email')}}" type="email" name="email" class="form-control form-control-user @error('email') is-invalid @enderror" id="email" placeholder="Email">
                        @error('email') <div class="invalid-feedback">{{$message}}</div> @enderror
                    </div>
                    <div class="form-group">
                        <div class="select-wrap">
                            <select value="{{old('province_destination')}}" name="province_destination" id="province_destination" class="form-control @error('province_destination') is-invalid @enderror">
                                <option value="{{Auth::user()->province_id}}">{{\DB::table('provinces')->where('province_id', Auth::user()->province_id)->value('title')}}</option>
                                @foreach ($provinces as $province => $value)
                                <option value="{{$province}}">{{$value}}</option>
                                @endforeach
                            </select>
                            @error('province_destination') <div class="invalid-feedback">{{$message}}</div> @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="select-wrap">
                            <select value="{{old('city_destination')}}" name="city_destination" id="city_destination" class="form-control  @error('city_destination') is-invalid @enderror">
                                <option value="{{Auth::user()->city_id}}">{{\DB::table('cities')->where('province_id', Auth::user()->city_id)->value('title')}}</option>
                            </select>
                            @error('city_destination') <div class="invalid-feedback">{{$message}}</div> @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <input value="{{old('address')}}" type="text" id="address" name="address" class="form-control form-control-user @error('address') is-invalid @enderror"  placeholder="Alamat Lengkap">
                        @error('address') <div class="invalid-feedback">{{$message}}</div> @enderror
                    </div>
                    <div class="form-group">
                        <input value="{{old('phone')}}" type="text" id="phone" name="phone" class="form-control form-control-user @error('phone') is-invalid @enderror" placeholder="Nomor Telepon">
                        @error('phone') <div class="invalid-feedback">{{$message}}</div> @enderror
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('section-footer')

<script type="text/javascript">
    function PreviewImage() {
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("uploadImage").files[0]);
        
        oFReader.onload = function(oFREvent) {
            document.getElementById("uploadPreview").src = oFREvent.target.result;
        };
    };
</script>

<script>
    $(document).ready(function(){
        $('select[name="province_destination"]').on('change', function(){
            let provinceId = $(this).val();
            // console.log(provinceId);
            
            if (provinceId) {
                jQuery.ajax({
                    url: "{{url('province')}}"+'/'+provinceId+'/cities',
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('select[name="city_destination"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="city_destination"]').append('<option value="'+ key +'">'+ value +'</option> ');
                        });
                    },
                });
            }else {
                $('select[name="city_destination"]').empty();
            }
        });
        
        
        
    });
    
    $('#fotoModal').on('show.bs.modal', function(event){
        var button = $(event.relatedTarget)
        var id = button.data('id')
        
        var modal = $(this)
        modal.find('.modal-body #id').val(id)
    });
    
    $('#ratingModal').on('show.bs.modal', function(event){
        var button = $(event.relatedTarget)
        var id = button.data('id')
        
        var modal = $(this)
        modal.find('.modal-body #id').val(id)
    });
    
    $('#dataModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) 
        var id = button.data('id')
        var name = button.data('name')
        var email = button.data('email')
        var phone = button.data('phone')
        var address = button.data('address')
        
        var modal = $(this)
        modal.find('.modal-body #id').val(id)
        modal.find('.modal-body #name').val(name)
        modal.find('.modal-body #email').val(email)
        modal.find('.modal-body #phone').val(phone)
        modal.find('.modal-body #address').val(address)
    });
</script>
<script>
    function openPage(pageName,elmnt,bgcolor, color) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablink");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].style.backgroundColor = "";
        }
        document.getElementById(pageName).style.display = "block";
        elmnt.style.backgroundColor = bgcolor;
        elmnt.style.color = color;
    }
    
    // Get the element with id="defaultOpen" and click on it
    document.getElementById("defaultOpen").click();
</script>

<script>
    function nextPage(pageName,elmnt,bgcolor, color) {
        var i, tabtransaksi, tabnext;
        tabtransaksi = document.getElementsByClassName("tabtransaksi");
        for (i = 0; i < tabtransaksi.length; i++) {
            tabtransaksi[i].style.display = "none";
        }
        tabnext = document.getElementsByClassName("tabnext");
        for (i = 0; i < tabnext.length; i++) {
            tabnext[i].style.backgroundColor = "";
        }
        document.getElementById(pageName).style.display = "block";
        elmnt.style.backgroundColor = bgcolor;
        elmnt.style.color = color;
    }
    
    // Get the element with id="defaultOpen" and click on it
    document.getElementById("defaultBuka").click();
</script>


@endsection