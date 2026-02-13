@php
    $qualifications = $listing->qualifications;
@endphp

@if($qualifications->count())
    <div class="col-12 col-md-12 col-lg-12 col-xl-12 mobile-section">
        <div class="row">
            <div class="mobile-section-heading">Qualifications</div>
        </div>
        <ul class="qualification-list">  
            @foreach($qualifications as $index=>$qualification)
            <li>  {{$qualification->name}}  </li>
            @endforeach
        </ul>
    </div>
@endif
