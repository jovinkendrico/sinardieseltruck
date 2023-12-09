<div class="form-group {{ $errors->has('plat') ? 'has-error' : ''}}">
    <label for="plat" class="control-label">{{ 'Plat' }}</label>
    <input class="form-control" name="plat" type="text" id="plat" value="{{ isset($truk->plat) ? $truk->plat : ''}}" >
    {!! $errors->first('plat', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('jenis') ? 'has-error' : ''}}">
    <label for="jenis" class="control-label">{{ 'Jenis' }}</label>
    <input class="form-control" name="jenis" type="text" id="jenis" value="{{ isset($truk->jenis) ? $truk->jenis : ''}}" >
    {!! $errors->first('jenis', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
