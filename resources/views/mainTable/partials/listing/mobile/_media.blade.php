@if($listing->media->isNotEmpty())
<div class="col-12 col-md-12 col-lg-12 col-xl-12 mobile-section carousel-full">
    <div class="row">
      <div class="mobile-section-heading"> Media </div>
    </div>
    <div class="mobile-media-slider">
      <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          @php 
            $medias = $listing->media->slice(0,count($listing->media));
          @endphp
          @foreach($medias as $key=>$media)
            <div class="carousel-item {{($key==0) ? "active" : "" }}"> <img src="{{ $media->getUrl('file_path') }}" alt=" "> </div>
          @endforeach
        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev"> <i class="fas fa-chevron-left" aria-hidden="true"></i> </a> <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next"> <i class="fas fa-chevron-right" aria-hidden="true"></i> </a> </div>
    </div>
  </div>
  @endif