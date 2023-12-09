@extends('layouts.app2')

@section('title','Supplier')

@section('content')
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Supplier {{ $supplier->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/admin/suppliers') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/admin/suppliers/' . $supplier->id . '/edit') }}" title="Edit Supplier"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                        <form method="POST" action="{{ url('admin/suppliers' . '/' . $supplier->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete Supplier" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $supplier->id }}</td>
                                    </tr>
                                    <tr><th> Nama </th><td> {{ $supplier->nama }} </td></tr><tr><th> Norek </th><td> {{ $supplier->norek }} </td></tr><tr><th> Alamat </th><td> {{ $supplier->alamat }} </td></tr><tr><th> Email </th><td> {{ $supplier->email }} </td></tr><tr><th> Notelp </th><td> {{ $supplier->notelp }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
