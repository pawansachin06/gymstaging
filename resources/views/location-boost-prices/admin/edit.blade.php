@extends('layouts.app')

@section('content')
    <h3 class="page-title">Edit Location Boost Price</h3>
    <div class="panel panel-default">
        <div class="panel-heading">
            Price without postcode will be considered as default for all postcodes.
        </div>
        <div class="panel-body">
            <form action="{{ route('admin.location-boost-prices.update', $item) }}" id="edit-form" method="post">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-xs-6 form-group">
                        <label class="control-label">Name</label>
                        <input type="text" name="name" value="{{ $item->name }}" required class="form-control" />
                    </div>
                    <div class="col-xs-6 form-group">
                        <label class="control-label">Postcode</label>
                        <input type="text" name="postcode" value="{{ $item->postcode }}" class="form-control" />
                    </div>
                    <div class="col-xs-6 form-group">
                        <label class="control-label">Price</label>
                        <input type="number" name="amount" value="{{ $item->amount }}" min="0.01" step="0.01" required class="form-control" />
                    </div>
                </div>
                <div class="">
                    <p data-js="form-msg"></p>
                    <button data-js="form-btn" type="submit" class="btn btn-success">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script type="text/javascript">
(function(){
    window.getErrorMessage = function (err, fallback = 'Something went wrong') {
        if (!err) return fallback;
        // jQuery / raw XHR
        if (err.responseJSON?.message) {
            return err.responseJSON.message;
        }
        if (err.responseText) {
            try {
                const json = JSON.parse(err.responseText);
                if (json?.message) return json.message;
            } catch {}
        }
        // native Error
        if (err instanceof Error && err.message) {
            return err.message;
        }
        // string
        if (typeof err === 'string') return err;
        // network / timeout custom
        if (err.message) return err.message;
        return fallback;
    };

    var editForm = document.getElementById('edit-form');
    var formMsg = editForm.querySelector('[data-js="form-msg"]');
    var formBtn = editForm.querySelector('[data-js="form-btn"]');
    editForm.addEventListener('submit', function(e) {
        e.preventDefault();
        formBtn.disabled = true;
        formMsg.textContent = 'Please wait...';
        var formData = new FormData(editForm);
        jQuery.ajax({
            method: 'post',
            data: formData,
            dataType: 'json',
            processData: false,
            contentType: false,
            url: editForm.getAttribute('action'),
        }).done(function (res) {
            formMsg.textContent = res.message;
        }).fail(function (err) {
            formMsg.textContent = getErrorMessage(err);
        }).always(function () {
            formBtn.disabled = false;
        });
    });
})();
</script>
@endpush
