@if($listing->results->isNotEmpty())

<div class="text-center"> <h2> Results </h2> </div>

<div class="owl-container">
    <div class="owl-carousel" id="results">
        @foreach($listing->results as $key => $result)
            <div class="item">
            <img src="{{ $result->getUrl('file_path') }}" > 
            </div>
        @endforeach 
    </div>
</div>
@endif
