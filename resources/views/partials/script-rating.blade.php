<script src="{!!asset('plugins/rater-master/rater.min.js')!!}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.rating_star').each(function(){
            $(this).rate({
                max_value: $(this).data('max-value'),
                step_size: 0.5,
                cursor: 'default',
                readonly: true,
            });
        })
    });
</script>
