@php
$provinces = \DB::table('provinces')->pluck('title', 'province_id');
// dd($provinces);
@endphp
<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
        <a class="navbar-brand" href="{{url('/')}}">Coffeenesia</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="oi oi-menu"></span> Menu
        </button>
        
        <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav ml-auto">
                
                <li class="nav-item"><a href="{{ url('/belanja') }}" class="nav-link">Shop</a></li> 
                <li class="nav-item">
                    
                    @guest
                    
                    <a href="#" data-target="#loginModal" data-toggle="modal" class="nav-link">
                        <i class="icon-shopping_cart">{{Cart::count()}}</i>
                    </a>
                    
                    @else
                    
                    <a href="{{ url('/cart') }}" class="nav-link">
                        <i class="icon-shopping_cart">{{Cart::count()}}</i>
                    </a>
                    
                    @endguest
                    
                </li>
                
                
                
                @guest
                <li class="nav-item">
                    <a class="nav-link" href="#" data-toggle="modal" data-target="#loginModal">{{ __('Masuk') }}</a>
                </li>
                @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" href="#" data-toggle="modal" data-target="#registerModal">{{ __('Daftar') }}</a>
                </li>
                @endif
                @else
                @php
                $data = \DB::table('orders')->where('status', 'order')->get()->all();
                // dd(count($data));
                @endphp
                
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('cekPembayaran', Auth::user()->id) }}"><i class="far fa-credit-card "></i><span class="badge badge-info"> {{count($data)}}</span></a>
                </li>
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>
                    
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>
                    <a class="dropdown-item" href="{{ url('profile') }}">
                        {{ __('Profile') }}
                    </a>
                    
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
            @if (Auth::user()->hasAnyRole('admin'))
            <li class="nav-item">
                <a class="nav-link" href="{{ route('users.index') }}">{{ __('Manage') }}</a>
            </li>
            
            
            @endif
            @endguest
        </ul>
        
    </div>
</div>
</nav>


<!-- Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Masuk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="form-group">
                        <input type="email" style="border-radius: 5px; font-size: 15px" name="email" class="form-control @error('email') is-invalid @enderror" id="email" aria-describedby="emailHelp" placeholder="Masukkan Alamat Email...">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="password" style="border-radius: 5px; font-size: 15px" name="password" class="form-control form-control-user @error('passwrod') is-invalid @enderror" id="password" placeholder="Password">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Masuk</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Daftar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="user" action="{{route('register')}}" enctype="multipart/form-data" method="POST">
                    @csrf
                    <div class="form-group">
                        <input value="{{old('name')}}" type="text" name="name" class="form-control form-control-user @error('name') is-invalid @enderror" id="exampleFirstName" placeholder="Username">
                        @error('name') <div class="invalid-feedback">{{$message}}</div> @enderror
                    </div>
                    <div class="form-group">
                        <input value="{{old('email')}}" type="email" name="email" class="form-control form-control-user @error('email') is-invalid @enderror" id="exampleInputEmail" placeholder="Email">
                        @error('email') <div class="invalid-feedback">{{$message}}</div> @enderror
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <input type="password" name="password" class="form-control form-control-user @error('password') is-invalid @enderror" id="exampleInputPassword" placeholder="Password">
                            @error('password') <div class="invalid-feedback">{{$message}}</div> @enderror
                        </div>
                        <div class="col-sm-6">
                            <input type="password" name="confirmpassword" class="form-control form-control-user @error('confirmpassword') is-invalid @enderror" id="exampleRepeatPassword" placeholder="Konfirmasi Password">
                            @error('confirmpassword') <div class="invalid-feedback">{{$message}}</div> @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="select-wrap">
                            <select value="{{old('province_destination')}}" name="province_destination" id="province_destination" class="form-control @error('province_destination') is-invalid @enderror">
                                <option style="color: gray" value="">--Provinsi--</option>
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
                                <option>--Kota--</option>
                            </select>
                            @error('city_destination') <div class="invalid-feedback">{{$message}}</div> @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <input value="{{old('address')}}" type="text" name="address" class="form-control form-control-user @error('address') is-invalid @enderror"  placeholder="Alamat Lengkap">
                        @error('address') <div class="invalid-feedback">{{$message}}</div> @enderror
                    </div>
                    <div class="form-group">
                        <input value="{{old('phone')}}" type="number" name="phone" class="form-control form-control-user @error('phone') is-invalid @enderror" placeholder="Nomor Telepon">
                        @error('phone') <div class="invalid-feedback">{{$message}}</div> @enderror
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Daftar</button>
                    </div>
                </form>
                <div class="text-left">
                    <p class="small">Sudah Punya Akun? <a href="#" data-dismiss="modal" data-toggle="modal" data-target="#loginModal">Masuk</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

