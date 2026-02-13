    <div class="panel-body">
        <div class="form-group">
            {{ Form::textarea('value', old('value', $modelval),  ['class' => 'form-control summernote','rows'=>5]) }}
        </div>
    </div>

@push('scripts')
    @include('partials.script-summernote')
@endpush


