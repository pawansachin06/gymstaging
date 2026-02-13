@extends('layouts.app')

@section('content')
    <h4 class="card-title">{{ \Illuminate\Support\Str::title(str_replace('-',' ', $slug)) }}</h4>
    {!! Form::open(array('url' => request()->fullUrl(), 'class' => 'form-horizontal m-t-40','files'=>true)) !!}
    @includeIf('admin.settings.partials.'.$slug)

    <div class="form-group row">
        <div class="offset-2 col-sm-10">
            {!! Form::submit( "Save", ['class' => 'btn btn-success']) !!}
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function(){
        if ($('.slim').length){
            $.getScript('{!!asset('vendor/slim/slim.kickstart.min.js')!!}');
            if (document.createStyleSheet){
                document.createStyleSheet('{{ asset('vendor/slim/slim.min.css') }}');
            }
            else {
                $("head").append($("<link rel='stylesheet' href='{{ asset('vendor/slim/slim.min.css') }}' type='text/css' media='screen' />"));
            }
        }
    });
</script>
@endpush
