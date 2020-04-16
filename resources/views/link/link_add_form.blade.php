<form action="{{route('links.store')}}" id="add-link-form" method="post">
    <div class="form-row">
        {{csrf_field()}}
        <input type="hidden" name="file_id" value="{{ $file->id }}">
        <div class="col-auto">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="single_view" id="one-time-view">
                <label class="form-check-label" for="one-time-view">
                   @lang('link.create.one_time_view')
                </label>
            </div>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="fa fa-link" aria-hidden="true"></i>
                @lang('link.create.generation_link')
            </button>
        </div>
    </div>
</form>
