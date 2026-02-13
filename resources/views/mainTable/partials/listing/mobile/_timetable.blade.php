@if($listing->timeTableUrl)
<div class="col-12 col-md-12 col-lg-12 col-xl-12 mobile-section">
    <div class="row">
      <div class="mobile-section-heading">Class Timetable</div>
    </div>
    <div class="mobile-timetable">
        <p>
            <a target="_blank" href="{{$listing->timeTableUrl}}" class="btn btn2 btn-block"  download="{{$listing->name}}"> View Class Timetable <i class="fas fa-download"></i></a>
        </p>
    </div>
</div>
@endif
