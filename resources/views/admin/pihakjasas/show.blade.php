@extends('layouts.app2')

@section('title','Pihak Jasa')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Pihak Jasa {{ $pihakjasa->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/admin/pihakjasas') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/admin/pihakjasas/' . $pihakjasa->id . '/edit') }}" title="Edit Pihakjasa"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                        <form method="POST" action="{{ url('admin/pihakjasas' . '/' . $pihakjasa->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete Pihakjasa" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $pihakjasa->id }}</td>
                                    </tr>
                                    <tr><th> Nama </th><td> {{ $pihakjasa->nama }} </td></tr><tr><th> Kontak </th><td> {{ $pihakjasa->kontak }} </td></tr><tr><th> Alamat </th><td> {{ $pihakjasa->alamat }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
