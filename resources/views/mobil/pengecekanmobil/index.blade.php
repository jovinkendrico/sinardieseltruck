@extends('layouts.app2')

@section('title','Pengecekan Mobil')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Data Pengecekan Mobil</h3>
              <a href="{{ route('pengecekan.create') }}" class="btn btn-success btn-sm float-right" title="Add New Pengecekan">
                <i class="fa fa-plus" aria-hidden="true"></i> Add New
            </a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Tanggal</th>
                  <th>Plat</th>
                  <th>Merk</th>
                  <th>Pemeriksa</th>
                  <th style="width: 20%">Action</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($pengecekans as $pengecekan)
                  <tr>
                      <td>{{$pengecekan->id}}</td>
                      <td>{{$pengecekan->tanggal}}</td>
                      <td>{{$pengecekan['truk']['plat']}}</td>
                      <td>{{$pengecekan['truk']['jenis']}}</td>
                      <td>{{$pengecekan->pemeriksa}}</td>
                      <td class="project-actions text-right">
                          <a class="btn btn-primary btn-sm" href="{{route('pengecekan.show',$pengecekan->id)}}">
                              <i class="fas fa-folder">
                              </i>
                              View
                          </a>
                          <a class="btn btn-info btn-sm" href="{{route('pengecekan.edit',$pengecekan->id)}}">
                              <i class="fas fa-pencil-alt">
                              </i>
                              Edit
                          </a>
                          <form method="post" action="{{route('pengecekan.delete',$pengecekan->id)}}" accept-charset="UTF-8" style="display:inline">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i>Delete
                            </button>
                        </form>
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
