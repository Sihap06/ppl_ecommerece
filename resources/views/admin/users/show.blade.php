@extends('admin.master')

@section('content')

<div class="container-fluid">
    <h2 class="text-center">Detail {{$user->name}}</h2>
    <div class="row justify-content-center">
        <div class="card col-lg-8 mt-5 p-5">
            @if ($user->avatar)
            <img src="{{asset('storage/'. $user->avatar)}}" width="300px" alt="">
            @else
            No Avatar
            @endif
        </div>
        
        
        <div class="col-lg-8 p-5">
            <div class="card mb-4 py-3 border-left-success">
                <div class="card-body">
                    <b>Nama :</b>
                    {{$user->name}}
                    <br>
                    <b>Email :</b>
                    {{$user->email}}
                    <br>
                    <b>Role :</b>
                    {{implode(', ', $user->roles()->get()->pluck('name')->toArray())}}
                    <br>
                    <b>Address :</b>
                    {{$user->address}}
                    <br>
                    <b>Phone :</b>
                    {{$user->phone}}
                    <br>
                    <b>Status :</b>
                    {{$user->status}}
                </div>
            </div>
        </div>
        
    </div>
</div>
</div>
@endsection