@if($listing->media->isNotEmpty())

@php
    $media_file = $listing->media->slice(0,1);
    
@endphp
    <div id="cg0">
        <div class="cgWrapper">
          @if($media_file[0])
            <div class="cgRow">
                <div class="cgMain">
                    <div class="cgMainImage"><img src="{{ $media_file[0]->getUrl('file_path') }}"  style="width: 798px; height: 362.727px;"></div>
                </div>
            </div>
            @endif
            <div class="cgRow">
                <div class="cgGrid">
                    <div class="cgGridLine cgFirstLine">
                        @php
                            $media_file = $listing->media->slice(0,9);                            
                        @endphp 
                       @if($media_file)
                            @foreach($media_file as $key => $media)
                                <div class="cgGridImage">
                                <img src="{{@$media->getUrl('file_path')}}" style="width: 75.3px; height: 75.3px;">
                                </div>
                            @endforeach
                       @endif
                        @if(count($listing->media)>9)
                            <div class="cgGridImage cgMoreImages" style="width: 75.3px; height: 75.3px;">
                            <div class="cgMoreImagesInner">More</div>
                            </div>
                        @endif
                        @php
                        $media_file = $listing->media->slice(9,1);                        
                        @endphp
                        @if(@$media_file[9])
                        <div class="cgGridImage" style="display: none;">
                            <img src="{{@$media_file[9]->getUrl('file_path')}}"  style="width: 75.3px; height: 75.3px;">
                        </div>
                        @endif
                       </div>
                        
                        <div class="cgGridLine notCentered">
                            @php
                            $media_file = $listing->media->slice(10,count($listing->media));                        
                            @endphp
                            @if($media_file)
                                @foreach($media_file as $key => $media)
                                    <div class="cgGridImage" style="margin-right: 5.29688px;">
                                    <img src="{{@$media->getUrl('file_path')}}" style="width: 75.3px; height: 75.3px;">
                                    </div>
                                @endforeach
                             @endif   
                        </div>			
                </div>
                
            </div>
            
            <div class="jrClear"></div>
            
        </div>
        
    </div>


@endif



	