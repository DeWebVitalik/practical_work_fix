<form onsubmit="if(confirm('@lang('link.delete.confirm')')){ return true }else{ return false }"
      action="{{ route('links.destroy',$link->id) }}" method="post">
    <input type="hidden" name="_method" value="DELETE">
    {{ csrf_field() }}
    <button type="submit" class="btn btn-outline-danger btn-sm">
        <i class="fa fa-trash-o" aria-hidden="true"></i>
    </button>
</form>