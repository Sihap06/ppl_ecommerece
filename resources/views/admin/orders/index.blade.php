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
                                @elseif($order->status == 'verifikasi')
                                <span class="badge bg-primary text-light">{{$order->status}}</span>
                                @elseif($order->status == 'batal')
                                <span class="badge bg-danger text-light">{{$order->status}}</span>
                                @elseif($order->status == 'proses')
                                <span class="badge bg-gradient-success text-light">{{$order->status}}</span>
                                @elseif($order->status == 'selesai')
                                <span class="badge bg-gradient-secondary text-light">{{$order->status}}</span>
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
                            </td>
                        </tr>
                        
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

@endsection