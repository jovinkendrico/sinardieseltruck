@extends('layouts.app2')

@section('title','Cash Masuk')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Data Kas Masuk</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <a href="{{ route('cashmasuk.create') }}" class="btn btn-success btn-sm" title="Add New Cash Masuk">
                  <i class="fa fa-plus" aria-hidden="true"></i> Add New
              </a>
              <br/>
              <br/>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Tanggal</th>
                  <th>Invoice</th>
                  <th>Akun</th>
                  <th>Total</th>
                  <th style="width: 20%">Action</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($cashmasuks as $cashmasuk)
                  <tr>
                      <td>{{$cashmasuk->tanggal}}</td>
                      <td>{{$cashmasuk->id_bukti}}</td>
                      <td>{{$cashmasuk['akunmasuk']['nomor_akun']}} - {{$cashmasuk['akunmasuk']['nama']}}</td>
                      <td>Rp {{$cashmasuk->total}}</td>


                      <td class="project-actions text-right">
                          <a class="btn btn-primary btn-sm" href="{{route('cashmasuk.show',$cashmasuk->id)}}">
                              <i class="fas fa-folder">
                              </i>
                              View
                          </a>
                          <a class="btn btn-info btn-sm" href="{{route('cashmasuk.edit',$cashmasuk->id)}}">
                              <i class="fas fa-pencil-alt">
                              </i>
                              Edit
                          </a>
                          <a class="btn btn-danger btn-sm" href="{{route('cashmasuk.delete',$cashmasuk->id)}}">
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

@endsection
