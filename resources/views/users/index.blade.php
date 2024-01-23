@extends('layouts.app2')

@section('title','User')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Data User</h3>
              <button type="button" class="btn btn-success btn-sm float-right" data-toggle="modal" data-target="#modal-lg">
                <i class="fa fa-plus" aria-hidden="true"></i> Add New
              </button>
            </a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Nama</th>
                  <th>Email</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($users as $user)
                  <tr>
                      <td>{{$user->id}}</td>
                      <td>{{$user->name}}</td>
                      <td>{{$user->email}}</td>
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
    <div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <form method="POST" action="{{route('users.store')}}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
            @csrf
                <div class="modal-header">
                    <h4 class="modal-title">Add New Users</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" id="email" name="email" placeholder="Masukkan email">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" value="Tambah">
                </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
@endsection
