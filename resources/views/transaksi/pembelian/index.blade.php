@extends('layouts.app2')

@section('title','Pembelian')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Data Pembelian</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <a href="{{ route('pembelian.create') }}" class="btn btn-success btn-sm" title="Add New Pembelian">
                  <i class="fa fa-plus" aria-hidden="true"></i> Add New
              </a>
              <br/>
              <br/>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Invoice</th>
                  <th>Tanggal</th>
                  <th>Supplier</th>
                  <th>Netto</th>
                  <th>Status</th>
                  <th>Jatuh Tempo</th>
                  <th style="width: 20%">Action</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($pembelians as $pembelian)
                  <tr>
                      <td>{{$pembelian->id_invoice}}</td>
                      <td>{{$pembelian->tanggal}}</td>
                      <td>{{$pembelian['supplier']['nama']}}</td>
                      <td>Rp. {{$pembelian->netto}}</td>
                      <td>{{$pembelian->status}}</td>
                      <td>{{$pembelian->jatuh_tempo}}</td>


                      <td class="project-actions text-right">
                          <a class="btn btn-primary btn-sm" href="{{route('pembelian.show',$pembelian->id)}}">
                              <i class="fas fa-folder">
                              </i>
                              View
                          </a>
                          <a class="btn btn-info btn-sm" href="{{route('pembelian.edit',$pembelian->id)}}">
                              <i class="fas fa-pencil-alt">
                              </i>
                              Edit
                          </a>
                          <a class="btn btn-danger btn-sm" href="{{route('pembelian.delete',$pembelian->id)}}">
                              <i class="fas fa-trash">
                              </i>
                              Delete
                          </a>
                      </td>

                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
<div class="container-fluid">

@endsection
