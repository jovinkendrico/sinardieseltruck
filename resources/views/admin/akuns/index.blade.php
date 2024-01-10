@extends('layouts.app2')

@section('title','Akun')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Data Akun</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-lg">
                    <i class="fa fa-plus" aria-hidden="true"></i> Add New
                  </button>
              <br/>
              <br/>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Nomor Akun</th>
                  <th>Tipe Akun</th>
                  <th>Debit</th>
                  <th>Kredit</th>
                  <th style="width: 20%">Action</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($akuns as $akun)
                  <tr>
                      <td>{{$akun->nomor_akun}}</td>
                      <td>{{$akun->nama}}</td>
                      <td>Rp. {{$akun->debit}}</td>
                      <td>Rp. {{$akun->kredit}}</td>
                      <td class="project-actions text-right ">

                          <a class="btn btn-primary btn-sm" href="{{route('subakuns.index',$akun->id)}}">
                              <i class="fas fa-folder">
                              </i>
                              View
                          </a>
                          <a class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-edit" data-id="{{ $akun->id }}" data-nama="{{$akun->nama}}" data-nomorakun="{{$akun->nomor_akun}}">
                            <i class="fas fa-pencil-alt"></i> Edit
                          </a>
                          <a class="btn btn-danger btn-sm" href="{{route('akuns.delete',$akun->id)}}">
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


    <div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <form method="POST" action="{{route('akuns.store')}}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
            @csrf
                <div class="modal-header">
              <h4 class="modal-title">Add New Akun</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="nomor_akun">Nomor Akun</label>
                            <input type="text" class="form-control" id="nomor_akun" name="nomor_akun" placeholder="Masukkan Nomor Akun">
                        </div>
                        <div class="form-group">
                            <label for="nomor_akun">Nama Akun</label>
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama Akun">
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

      <div class="modal fade" id="modal-edit">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Akun</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('akuns.update', ':id') }}" id="editForm" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="nomor_akun">Nomor Akun</label>
                                <input type="text" class="form-control" id="edit_nomor_akun" name="edit_nomor_akun"  placeholder="Masukkan Nomor Akun">
                            </div>
                            <div class="form-group">
                                <label for="nama">Nama Akun</label>
                                <input type="text" class="form-control" id="edit_nama" name="edit_nama"  placeholder="Masukkan Nama Akun">
                            </div>
                        </div>
                    </div>
                    <!-- Add other form fields as needed -->

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" value="Update">
                    </div>
                </form>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

    @endsection
