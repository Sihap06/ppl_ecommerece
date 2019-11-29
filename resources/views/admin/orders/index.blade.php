@extends('admin.master')

@section('content')

<div class="container-fluid">
    {{-- @dd($orders) --}}
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Daftar Order</h1>
    
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Status</th>
                            <th>Pembeli</th>
                            <th>Produk</th>
                            <th>Total quantity</th>
                            <th>Total biaya</th>
                            <th>Tanggal pesen</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php
                    $kampang = $orders->all();    
                    @endphp
                        @foreach ($kampang as $order)
                        {{-- @dd($order['products']) --}}

                        <tr>
                            <td>
                                @if ($order->status == 'booked')
                                <span class="badge bg-warning text-light">{{$order->status}}</span>
                                @elseif($order->status == 'order')
                                <span class="badge bg-info text-light">{{$order->status}}</span>
                                @endif
                            </td>
                            <td>
                                {{$order->nama_depan}}
                                <br>
                                <small>{{$order->email}}</small>
                            </td>
                            <td>
                                @php
                                $items = json_decode($order->items);
                                @endphp
                                @foreach ($items as $item)
                                <span>{{$item}},</span>
                                @endforeach
                            </td>
                            <td>
                                @php
                                $qty = json_decode($order->qty);
                                @endphp
                                @foreach ($qty as $dta)
                                <span>{{$dta}},</span>
                                @endforeach
                            </td>
                            <td>Rp. {{number_format($order->subtotal + $order->cost)}}</td>
                            <td>{{date('Y-m-d', strtotime($order->created_at))}}</td>
                            <td>
                                <a href="{{ url('/detail', $order->id)}}">
                                    <button type="button" class="btn btn-info btn-sm">Detail</button>
                                </a>
                                <a href="{{ url('/batal', $order->id)}}">
                                    <button type="button" class="btn btn-danger btn-sm">Batal</button>
                                </a>
                                {{-- <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#exampleModalCenter">
                                    Hapus
                                </button> --}}
                            </td>
                        </tr>
                        
                        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Hapus</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Apakah anda yakin ingin menghapus data?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <form class="float-left mr-1" action="/orders/{{$order->id}}" method="POST">
                                            {{ method_field('DELETE') }}
                                            @csrf
                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        

                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="10">
                                {{-- {{$orders->appends(Request::all())->links()}} --}}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

@endsection