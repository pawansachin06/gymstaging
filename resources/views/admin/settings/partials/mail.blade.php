<div class="form-group row">
    {{ html()->label('Reply To Email Address', 'value.REPLYTO')->class('col-sm-2 col-form-label') }}
    <div class="col-sm-10">
        {{ html()->email('value[REPLYTO]', old('value.REPLYTO', $modelval['REPLYTO'] ?? ''))->class('form-control') }}
    </div>
</div>
<div class="form-group row">
    {{ html()->label('Confirm Mail Bottom', 'value.CONFIRM_MAIL_BOTTOM')->class('col-sm-2 col-form-label') }}
    <div class="col-sm-10">
        {{ html()->textarea('value[CONFIRM_MAIL_BOTTOM]', old('value.CONFIRM_MAIL_BOTTOM', $modelval['CONFIRM_MAIL_BOTTOM'] ?? ''))->class('form-control summernote') }}
    </div>
</div>

<div class="form-group row" id="after_play_row">
    <div class="col-sm-2">
        {{ html()->label('After Play Automatic Email', 'value.AFTER_PLAYED_MAIL')->class('col-form-label') }}
        <button type="button" id="preview_mail" class="btn btn-sm btn-primary">Send Preview Mail</button>
    </div>
    <div class="col-sm-10">
        {{ html()->textarea('value[AFTER_PLAYED_MAIL]', old('value.AFTER_PLAYED_MAIL', $modelval['AFTER_PLAYED_MAIL'] ?? ''))->class('form-control summernote') }}
        <small class="form-text text-muted">Available Tags: <code>{TEAM_NAME}</code> <code>{ROOM_NAME}</code> <code>{BOOKING_TIME}</code> <code>{TEAM_PHOTO}</code> <code>{FB_PHOTO_BUTTON}</code></small>
    </div>
</div>

<div class="form-group row">
    {{ html()->label('Enable After Play Automatic Email', 'value.NOTIFY_AFTER_PLAY')->class('col-sm-2 col-form-label') }}
    <div class="col-sm-10 mt-1">
        <div class="switch">
            <label>
                {{ html()->hidden('value[NOTIFY_AFTER_PLAY]', 0) }}
                {{ html()->checkbox('value[NOTIFY_AFTER_PLAY]', (bool)($modelval['NOTIFY_AFTER_PLAY'] ?? false), 1) }}
                <span class="lever switch-col-blue"></span>
            </label>
        </div>
    </div>
</div>

<hr>

<h2>SMS Settings</h2>

<div class="form-group row">
    {{ html()->label('Enable SMS Confirmation', 'value.SMS_CONFIRMATION')->class('col-sm-2 col-form-label') }}
    <div class="col-sm-10 mt-1">
        <div class="switch">
            <label>
                {{ html()->hidden('value[SMS_CONFIRMATION]', 0) }}
                {{ html()->checkbox('value[SMS_CONFIRMATION]', (bool)($modelval['SMS_CONFIRMATION'] ?? false), 1) }}
                <span class="lever switch-col-blue"></span>
            </label>
        </div>
    </div>
</div>

<div class="form-group row">
    {{ html()->label('Enable SMS Reminder (24 hours before)', 'value.SMS_REMINDER')->class('col-sm-2 col-form-label') }}
    <div class="col-sm-10 mt-1">
        <div class="switch">
            <label>
                {{ html()->hidden('value[SMS_REMINDER]', 0) }}
                {{ html()->checkbox('value[SMS_REMINDER]', (bool)($modelval['SMS_REMINDER'] ?? false), 1) }}
                <span class="lever switch-col-blue"></span>
            </label>
        </div>
    </div>
</div>

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#preview_mail').on('click', function () {
                var $_btn = $(this),
                    $_btnTxt = $_btn.html();

                $.ajax({
                    method: "POST",
                    url: "{{ route('subscriber.waivers.preview_mail') }}",
                    data: $_btn.closest('form').serialize(),
                    beforeSend: function () {
                        $_btn.html($_btn.data('loading-text') ? $_btn.data('loading-text') : 'Loading...').attr('disabled', true);
                    },
                    success: function (html) {
                        swal({
                            title: 'Mail Sent',
                            html: 'A sample preview mail has been sent',
                            type: 'success',
                            confirmButtonClass: 'btn btn-warning',
                            confirmButtonText: 'Close'
                        });
                    },
                    error: function (jqXhr) {
                        swal_error(jqXhr);
                    },
                    complete: function () {
                        $_btn.html( $_btnTxt ).attr('disabled', false);
                    },
                });
            });
        });
    </script>
@endpush
