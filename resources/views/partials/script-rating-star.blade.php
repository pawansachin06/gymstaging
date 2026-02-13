<script src="{!!asset('plugins/star-rating-svg-master/jquery.star-rating-svg.min.js')!!}"></script>
<link rel='stylesheet' href="{{ asset('plugins/star-rating-svg-master/star-rating-svg.css') }}">
<script type="text/javascript">
    $(document).ready(function() {
        $(".rating-star").starRating({
            totalStars: 5,
            starShape: 'rounded',
            starSize: 18,
            emptyColor: 'lightgray',
            hoverColor: '#000000',
            activeColor: '#000000',
            useGradient: false,
            readOnly: true,
        });

        $(".rating").starRating({
            totalStars: 5,
            starShape: 'rounded',
            starSize: 18,
            emptyColor: 'lightgray',
            hoverColor: '#000000',
            activeColor: '#000000',
            useGradient: false,
            disableAfterRate: false,
            ratedColor: '#000000',
            callback: function(currentRating, $el){
                $value = $('#rating').val(currentRating);
            }
        });
    });
</script>
