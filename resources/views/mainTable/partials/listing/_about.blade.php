@if($listing->about)
    <div class="list-about">
        <h2> About </h2>
        <p>{!! nl2br(@$listing->about) !!}</p>
    </div>
@endif
