@php
    $address = @$listing->address;
@endphp
<div class="col-12 col-md-12 col-lg-12 col-xl-12">
    <div class="mobile-address">
        {{ implode(', ', array_filter([@$address->name, @$address->street, @$address->city, @$address->county, @$address->postcode])) }}
    </div>
</div>
