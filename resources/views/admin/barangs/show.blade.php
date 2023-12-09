@extends('layouts.app2')

@section('title','Barang')

@section('content')
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Barang {{ $barang->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/admin/barangs') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/admin/barangs/' . $barang->id . '/edit') }}" title="Edit Barang"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                        <form method="POST" action="{{ url('admin/barangs' . '/' . $barang->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete Barang" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $barang->id }}</td>
                                    </tr>
                                    <tr><th> Nama </th><td> {{ $barang->nama }} </td></tr><tr><th> Harga </th><td> {{ $barang->harga }} </td></tr><tr><th> Satuanbesar </th><td> {{ $barang->satuanbesar }} </td></tr><tr><th> Satuankecil </th><td> {{ $barang->satuankecil }} </td></tr><tr><th> Uombesar </th><td> {{ $barang->uombesar }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
