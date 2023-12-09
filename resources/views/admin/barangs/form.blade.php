<div class="form-group {{ $errors->has('nama') ? 'has-error' : ''}}">
    <label for="nama" class="control-label">{{ 'Nama' }}</label>
    <input class="form-control" name="nama" type="text" id="nama" value="{{ isset($barang->nama) ? $barang->nama : ''}}" >
    {!! $errors->first('nama', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('harga') ? 'has-error' : ''}}">
    <label for="harga" class="control-label">{{ 'Harga' }}</label>
    <input class="form-control" name="harga" type="number" id="harga" value="{{ isset($barang->harga) ? $barang->harga : ''}}" >
    {!! $errors->first('harga', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('satuanbesar') ? 'has-error' : ''}}">
    <label for="satuanbesar" class="control-label">{{ 'Satuanbesar' }}</label>
    <input class="form-control" name="satuanbesar" type="number" id="satuanbesar" value="{{ isset($barang->satuanbesar) ? $barang->satuanbesar : ''}}" >
    {!! $errors->first('satuanbesar', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('satuankecil') ? 'has-error' : ''}}">
    <label for="satuankecil" class="control-label">{{ 'Satuankecil' }}</label>
    <input class="form-control" name="satuankecil" type="number" id="satuankecil" value="{{ isset($barang->satuankecil) ? $barang->satuankecil : ''}}" >
    {!! $errors->first('satuankecil', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('uombesar') ? 'has-error' : ''}}">
    <label for="uombesar" class="control-label">{{ 'Uombesar' }}</label>
    <input class="form-control" name="uombesar" type="text" id="uombesar" value="{{ isset($barang->uombesar) ? $barang->uombesar : ''}}" >
    {!! $errors->first('uombesar', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('uomkecil') ? 'has-error' : ''}}">
    <label for="uomkecil" class="control-label">{{ 'Uomkecil' }}</label>
    <input class="form-control" name="uomkecil" type="text" id="uomkecil" value="{{ isset($barang->uomkecil) ? $barang->uomkecil : ''}}" >
    {!! $errors->first('uomkecil', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('stok') ? 'has-error' : ''}}">
    <label for="stok" class="control-label">{{ 'Stok' }}</label>
    <input class="form-control" name="stok" type="number" id="stok" value="{{ isset($barang->stok) ? $barang->stok : ''}}" >
    {!! $errors->first('stok', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
