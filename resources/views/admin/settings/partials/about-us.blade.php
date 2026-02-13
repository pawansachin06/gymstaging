    <div class="panel-body">
        <div class="form-group">
            {{ html()->textarea('value', old('value'))->class('form-control summernote')->rows(5) }}
        </div>
    </div>

@push('scripts')
    @include('partials.script-summernote')
@endpush


