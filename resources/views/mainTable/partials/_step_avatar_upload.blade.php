<div class="col-12 col-md-12 col-lg-6 col-xl-6 mx-auto">
    <div class="wrapper">
        <div class="file-upload" id="upload-holder">
            {{ html()->file('avatar') }}
            <i class="fas fa-plus"></i>
        </div>
    </div>
    <button type="button" class="btn btn2 btn-block" onclick="$('#step-form').steps('next');">
        Next
    </button>
</div>
