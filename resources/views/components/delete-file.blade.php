<form onsubmit="if(confirm('@lang('file-delete.confirm')')){ return true }else{ return false }"
      action="{{ route('files.destroy',$file->id) }}" method="post">
    <input type="hidden" name="_method" value="DELETE">
    {{ csrf_field() }}
    <button type="submit" class="btn btn-outline-danger btn-sm">
        @lang('file-delete.button')
    </button>
</form>