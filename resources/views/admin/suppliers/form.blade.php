<div class="form-group {{ $errors->has('nama') ? 'has-error' : ''}}">
    <label for="nama" class="control-label">{{ 'Nama' }}</label>
    <input class="form-control" name="nama" type="text" id="nama" value="{{ isset($supplier->nama) ? $supplier->nama : ''}}" >
    {!! $errors->first('nama', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('norek') ? 'has-error' : ''}}">
    <label for="norek" class="control-label">{{ 'Norek' }}</label>
    <input class="form-control" name="norek" type="text" id="norek" value="{{ isset($supplier->norek) ? $supplier->norek : ''}}" >
    {!! $errors->first('norek', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('alamat') ? 'has-error' : ''}}">
    <label for="alamat" class="control-label">{{ 'Alamat' }}</label>
    <input class="form-control" name="alamat" type="text" id="alamat" value="{{ isset($supplier->alamat) ? $supplier->alamat : ''}}" >
    {!! $errors->first('alamat', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
    <label for="email" class="control-label">{{ 'Email' }}</label>
    <input class="form-control" name="email" type="text" id="email" value="{{ isset($supplier->email) ? $supplier->email : ''}}" >
    {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('notelp') ? 'has-error' : ''}}">
    <label for="notelp" class="control-label">{{ 'Notelp' }}</label>
    <input class="form-control" name="notelp" type="text" id="notelp" value="{{ isset($supplier->notelp) ? $supplier->notelp : ''}}" >
    {!! $errors->first('notelp', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
