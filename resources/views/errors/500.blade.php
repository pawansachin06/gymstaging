@extends('layouts.front2')

@section('content')
<article class="container">
    <section class="my-4 text-center">
        <div class="px-3 py-4 rounded-3 bg-white shadow-md">
            <h1 class="h4 font-weight-bold">
                Something went wrong
            </h1>
            <p class="mb-0 font-weight-semibold">
                {{ $exception?->getMessage() }}
            </p>
        </div>
    </section>
</article>
@endsection