@extends('layouts.index1')

@section('container')

@php
$provinces = \DB::table('provinces')->pluck('title', 'province_id');
@endphp

<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center">
            
            <div class="card align-items-center p-3 col-lg-6 mb-5 ftco-animate">
                @if (Auth::user()->avatar)
                
                <a href="{{asset('storage/'. Auth::user()->avatar)}}" class="image-popup"><img width="400px" src="{{asset('storage/'. Auth::user()->avatar)}}" class="align-content-center img-fluid" alt="Avatar"></a>
                
                @else
                
                <a href="images/default_avatar.png" class="image-popup"><img width="400px" src="images/default_avatar.png" class="img-fluid" alt="Colorlib Template"></a>
                
                @endif
                <br>
                <button data-toggle="modal" data-target="#fotoModal" class="btn btn-outline-success mt-5">Ganti Foto</button>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="card p-3 align-items-center col-lg-6 pl-md-5 ftco-animate">
                <h5 class="text-capitalize">{{Auth::user()->name}}</h5>
                <p><span>{{Auth::user()->email}}</span></p>
                <p><span>{{DB::table('provinces')->where('province_id', Auth::user()->province_id)->value('title')}} - {{DB::table('cities')->where('city_id', Auth::user()->city_id)->value('title')}}</span></p>
                <p><span>{{Auth::user()->phone}}</span></p>
                <p class="text-capitalize"><span>{{Auth::user()->address}}</span></p>
                <p><a href="#" data-name="{{Auth::user()->name}}" data-email="{{Auth::user()->email}}" data-phone="{{Auth::user()->phone}}" data-address="{{Auth::user()->address}}" data-toggle="modal" data-target="#dataModal" class="btn btn-outline-success">Edit Profile</a></p>
            </div>
        </div>
    </div>
</section>

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
                <div class="text-left">
                    <p class="small">Sudah Punya Akun? <a href="#" data-dismiss="modal" data-toggle="modal" data-target="#loginModal">Masuk</a></p>
                </div>
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
    
    $('#dataModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) 
        var name = button.data('name')
        var email = button.data('email')
        var phone = button.data('phone')
        var address = button.data('address')
        
        var modal = $(this)
        modal.find('.modal-body #name').val(name)
        modal.find('.modal-body #email').val(email)
        modal.find('.modal-body #phone').val(phone)
        modal.find('.modal-body #address').val(address)
    });
</script>


@endsection