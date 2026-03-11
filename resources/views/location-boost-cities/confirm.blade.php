@extends('layouts.front')

@push('styles')
<link rel="stylesheet" href="/assets/css/location-boost-cities.css?v={{ config('app.version') }}" />
@endpush

@section('content')
<article class="container">
    <section class="my-4 text-center">
        <div class="px-3 py-4 rounded-3 bg-white shadow-md">
            <h1 class="h4 font-weight-bold">
                Processing Payment
            </h1>
            <p class="mb-0">
                You will be redirected automatically.<br />
                Please wait...
            </p>
        </div>
    </section>
</article>
@endsection

@push('scripts')
<script type="text/javascript">
(function(){
    setTimeout(function(){
        window.location.reload();
    }, 2000);
})();
</script>
@endpush