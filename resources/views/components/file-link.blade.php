<div class="input-group">
    <input type="text" id="link-{{ $link->id }}" class="form-control" value="{{ $link->alias }}">
    <div class="input-group-append">
        <button class="btn btn-outline-info btn-clipboard" type="button" data-clipboard-target="#link-{{ $link->id }}">
            <i class="fa fa-files-o" aria-hidden="true"></i>
        </button>
    </div>
</div>