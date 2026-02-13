@push('head_scripts')
    <link rel="stylesheet" href="{{ asset('plugins/nice-select/nice-select.css') }}">
@endpush
<script src="{{ asset('plugins/nice-select/jquery.nice-select.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.niceselect').niceSelect();
    });
</script>


