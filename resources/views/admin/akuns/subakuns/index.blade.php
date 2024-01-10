@extends('layouts.app2')

@section('title','Sub Akun')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Data {{$akun->nama}}</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <a href="{{ url('/admin/akuns') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
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
                  <th>Saldo</th>
                  <th style="width: 20%">Action</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($subakuns as $subakun)
                  <tr>
                      <td>{{$subakun->nomor_akun}}</td>
                      <td>{{$subakun->nama}}</td>
                      <td>Rp. {{ number_format($subakun->debit, 0, ',', '.') }}</td>
                      <td>Rp. {{ number_format($subakun->kredit, 0, ',', '.') }}</td>
                      <td>Rp. {{ number_format($subakun->saldo, 0, ',', '.') }}</td>
                      <td class="project-actions text-right">
                          <a class="btn btn-primary btn-sm" href="{{route('subakuns.show',$subakun->id)}}">
                              <i class="fas fa-folder">
                              </i>
                              View
                          </a>
                          <a class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-edit" data-id="{{ $subakun->id }}" data-nama="{{$subakun->nama}}" data-nomorakun="{{$subakun->nomor_akun}}">
                            <i class="fas fa-pencil-alt"></i> Edit
                          </a>
                          <a class="btn btn-danger btn-sm" href="{{route('subakuns.delete',$subakun->id)}}">
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
</div>


    <div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <form method="POST" action="{{route('subakuns.store')}}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
            @csrf
                <div class="modal-header">
                    <h4 class="modal-title">Add New Sub Akun</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="nomor_akun">Nomor Akun</label>
                                <input type="hidden" class="form-control" id="id_akun" name="id_akun" value="{{$akun->id}}">
                                <input type="text" class="form-control" id="nomor_akun" name="nomor_akun" placeholder="Masukkan Nomor Akun" value="{{ $latestSubAkun ?  $latestSubAkun->nomor_akun + 1 : $akun->nomor_akun . '1' }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="nomor_akun">Nama Akun</label>
                                <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama Akun">
                            </div>
                            <div class="form-group">
                                <label for="saldo">Saldo</label>
                                <input type="number" class="form-control" id="saldo" name="saldo" placeholder="Masukkan Saldo">
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
                <h4 class="modal-title">Edit Sub Akun</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('subakuns.update', ':id') }}" id="editForm" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="nomor_akun">Nomor Akun</label>
                                <input type="hidden" class="form-control" id="id_akun" name="id_akun" value="{{$akun->id}}">
                                <input type="text" class="form-control" id="edit_nomor_akun" name="edit_nomor_akun"  placeholder="Masukkan Nomor Akun" readonly>
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
