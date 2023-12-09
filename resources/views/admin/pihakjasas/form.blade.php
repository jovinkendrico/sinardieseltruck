<div class="form-group {{ $errors->has('nama') ? 'has-error' : ''}}">
    <label for="nama" class="control-label">{{ 'Nama' }}</label>
    <input class="form-control" name="nama" type="text" id="nama" value="{{ isset($pihakjasa->nama) ? $pihakjasa->nama : ''}}" >
    {!! $errors->first('nama', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('kontak') ? 'has-error' : ''}}">
    <label for="kontak" class="control-label">{{ 'Kontak' }}</label>
    <input class="form-control" name="kontak" type="text" id="kontak" value="{{ isset($pihakjasa->kontak) ? $pihakjasa->kontak : ''}}" >
    {!! $errors->first('kontak', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('alamat') ? 'has-error' : ''}}">
    <label for="alamat" class="control-label">{{ 'Alamat' }}</label>
    <input class="form-control" name="alamat" type="text" id="alamat" value="{{ isset($pihakjasa->alamat) ? $pihakjasa->alamat : ''}}" >
    {!! $errors->first('alamat', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
