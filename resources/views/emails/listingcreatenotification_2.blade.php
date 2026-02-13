@component('mail::message')
<style>
    .welcome-content h3, .started-content h6, .started-content p, .welcome-content {
        text-align: center;
        font-size: 16px;
    }
    .welcome-content h4 {
        color: #000;
    }
    .started-content h6 {
        margin-bottom: 15px;
    }
    .link-color {
        font-size: 20px;
    }
</style>
<table class="welcome-content">
    <tr>
        <td>
            <h3>Welcome, {{$name}}!</h3>
            <h4>Here are 4 tips to get you started:</h4>
            <div class="started-content">
                <h6>Complete your listing</h6>
                <p>Make sure your listing is complete with correct contact
                    information.</p>
            </div>
            <div class="started-content">
                <h6>Upload Images!</h6>
                <p>Upload good quality images of you working with clients.</p>
            </div>
            <div class="started-content">
                <h6>Get Tagged</h6>
                <p>If you are based at a facility with a GymSelect listing, get
                    them to tag and promote you.</p>
            </div>
            <div class="started-content">
                <h6>Build up Reviews</h6>
                <p>Share the link below with your clients. Start building up
                    your reviews and ratings!</p>
            </div>
            <a class="link-color" href="{{route('listing.view', $slug)}}">{{ $webUrl }}</a>
            <!-- <h5>Thank for signing up!</h5>
            <h5>The GymSelect Team</h5> -->
        </td>
    </tr>
</table>
@endcomponent
