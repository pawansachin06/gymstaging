<x-front-layout>
    <section class="container py-4">
        <x-ui.page-header
            class="mb-4"
            title="Processing Payment"
            subtitle="Please wait while we confirm payment..."
        />
    </section>
    <script type="text/javascript">
        (function(){
            setInterval(function() {
                location.reload();
            }, 4000); // 4000 milliseconds = 4 seconds
        })();
    </script>
</x-front-layout>