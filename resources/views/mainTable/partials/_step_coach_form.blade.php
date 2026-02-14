<div class="col-12 col-md-12 col-lg-12 col-xl-12 mx-auto" id="coach-step4">
    <div class="form-section text-center">
        <div class="form-group">
            <label> *Name </label>
            <p>Enter your name. This will also be used to create your GymSelect profile url.</p>
            {{ html()->text('listing[name]', old('listing.name', $listing->name))->class('form-control w-50') }}
        </div>
    </div>
    <div class="form-section text-center">
        <div class="form-group">
            <label>*Business </label>
            <p>Choose the category thats suits you best.</p>
            <div class="col-12 col-md-6 offset-md-6 col-lg-4 offset-lg-4 col-xl-4 offset-xl-4">
                {{ html()->select('listing[category_id]', $categories, old('listing.category_id', $listing->category_id))->class('niceselect w-100')->placeholder('Choose...') }}
            </div>
        </div>
    </div>
    <div class="form-section text-center">
        <div class="form-group">
            <label>*Profile Photo </label>
            <p>Upload logo or photo.</p>
            <div class="wrapper">
                <div class="file-upload profilephoto" id="upload-holder">
                    {{ html()->file('listing[profile_image]')->id('profile_image') }}
                    <i class="fas fa-plus" aria-hidden="true"></i></div>
            </div>
        </div>
    </div>
    <div class="form-section text-center">
        <div class="form-group">
            <label>*Cover Photo </label>
            <p>This image will show up in search results and at the top of your profile</p>
            <div class="wrapper">
                <div class="file-upload coverphoto" id="upload-holder-cover">
                    {{ html()->file('listing[cover_image]')->id('cover_image') }}
                    <i class="fas fa-plus" aria-hidden="true"></i></div>
            </div>
        </div>
    </div>

    <div class="form-section text-center">
        <div class="form-group">
            <label>*Call to Action</label>
            <p>Select which action you would most like users to take:</p>
            <div class="row ctas-list text-left">
                <div class="col-12 col-md-12 col-lg-6 col-xl-6">
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            {{ html()->hidden('listing[ctas][site][enabled]', 0) }}
                            {{ html()->checkbox('listing[ctas][site][enabled]', (bool)($listing->ctas->site->enabled ?? false), 1)->class('custom-control-input')->id('cta_site') }}
                            <label class="custom-control-label" for="cta_site">Visit Site (Website or funnel)</label>
                            <div class="hiddenfield">
                                {{ html()->text('listing[ctas][site][value]', old('listing.ctas.site.value', $listing->ctas->site->value ?? ''))->class('form-control')->placeholder('Enter link') }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-6 col-xl-6">
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            {{ html()->hidden('listing[ctas][enquire][enabled]', 0) }}
                            {{ html()->checkbox('listing[ctas][enquire][enabled]', (bool)($listing->ctas->enquire->enabled ?? false), 1)->class('custom-control-input')->id('cta_enquire') }}
                            <label class="custom-control-label" for="cta_enquire">Enquire (Send them to a form/ Typeform)</label>
                            <div class="hiddenfield">
                                {{ html()->text('listing[ctas][enquire][value]', old('listing.ctas.enquire.value', $listing->ctas->enquire->value ?? ''))->class('form-control')->placeholder('Enter link') }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-6 col-xl-6">
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            {{ html()->hidden('listing[ctas][call][enabled]', 0) }}
                            {{ html()->checkbox('listing[ctas][call][enabled]', (bool)($listing->ctas->call->enabled ?? false), 1)->class('custom-control-input')->id('cta_call') }}
                            <label class="custom-control-label" for="cta_call">Call</label>
                            <div class="hiddenfield">
                                {{ html()->text('listing[ctas][call][value]', old('listing.ctas.call.value', $listing->ctas->call->value ?? ''))->class('form-control')->placeholder('Enter phone number') }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-6 col-xl-6">
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            {{ html()->hidden('listing[ctas][email][enabled]', 0) }}
                            {{ html()->checkbox('listing[ctas][email][enabled]', (bool)($listing->ctas->email->enabled ?? false), 1)->class('custom-control-input')->id('cta_email') }}
                            <label class="custom-control-label" for="cta_email">Email</label>
                            <div class="hiddenfield">
                                {{ html()->text('listing[ctas][email][value]', old('listing.ctas.email.value', $listing->ctas->email->value ?? ''))->class('form-control')->placeholder('Enter email') }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-6 col-xl-6">
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            {{ html()->hidden('listing[ctas][whatsapp][enabled]', 0) }}
                            {{ html()->checkbox('listing[ctas][whatsapp][enabled]', (bool)($listing->ctas->whatsapp->enabled ?? false), 1)->class('custom-control-input')->id('cta_whatsapp') }}
                            <label class="custom-control-label" for="cta_whatsapp">Whatsapp</label>
                            <div class="hiddenfield">
                                {{ html()->select('listing[ctas][whatsapp][code]', \App\Http\Helpers\AppHelper::CountryCode(), old('listing.ctas.whatsapp.code', $listing->ctas->whatsapp->code ?? ''))->class('form-control country-selector float-left') }}
                                {{ html()->text('listing[ctas][whatsapp][value]', old('listing.ctas.whatsapp.value', $listing->ctas->whatsapp->value ?? ''))->class('form-control w-70')->placeholder('Enter whatsapp') }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-6 col-xl-6">
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            {{ html()->hidden('listing[ctas][custom][enabled]', 0) }}
                            {{ html()->checkbox('listing[ctas][custom][enabled]', (bool)($listing->ctas->custom->enabled ?? false), 1)->class('custom-control-input')->id('cta_custom') }}
                            <label class="custom-control-label w-100" for="cta_custom">
                                {{ html()->text('listing[ctas][custom][label]', old('listing.ctas.custom.label', $listing->ctas->custom->label ?? ''))->class('form-control')->placeholder('Other / Custom') }}
                            </label>
                            <div class="hiddenfield">
                                {{ html()->text('listing[ctas][custom][value]', old('listing.ctas.custom.value', $listing->ctas->custom->value ?? ''))->class('form-control')->placeholder('Enter Link') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--
            @if(request()->routeIs('admin.business.edit'))
                <div class="row">
                    <div class="col-md-12 mb-4">
                      <div class="signup-heading">
                        <h4>Reviews <span style="color: #17a2b8">Boost</span></h4>
                        <p>Select and manage which plateform you would like to add reviews from</p>
                    </div>
                </div>
            </div>

            <div class="form-section review text-center">
                <div class="form-group">
                    <div class="row text-left">
                        <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                            <div class="content">
                                <!-- Nav pills -->
                                <ul class="nav nav-pills" role="tablist">
                                  <li class="nav-item active">
                                    <img src="{{ asset('gymselect\images\google.png') }}">
                                    <span>Google</span>
                                    <a class="nav-link" data-toggle="pill" href="#login">Add</a>
                                </li>
                                <li class="nav-item">
                                    <img src="{{ asset('gymselect\images\facebook.png') }}">
                                    <span>Facebook</span>
                                    <a class="nav-link" data-toggle="pill" href="#regis">Add</a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content reviews">
                              <div id="login" class="container tab-pane">

                                <div class="row">
                                    <div class="col-md-5">
                                        <h3>New Google plateform</h3>
                                        <p>Set up the source of your reviews on google!</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <h6>Enter your Google place ID</h6>
                                    </div>
                                    <div class="col-md-8">
                                     <form>
                                      <div class="form-group">
                                        <div class="d-flex">
                                            <input type="text" class="form-control mr-2" id="InputName" placeholder="Google place ID">
                                            <button type="submit" id="load_google_reviews" class="btn btn-primary">Load</button>
                                        </div>
                                        <small class="form-text text-muted"><a href="#" data-toggle="modal" data-target="#myModal">Get your Google Place ID</a> </small>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <hr>
                        <div>
                         <button type="submit" class="btn btn-cancel" id="hide_div">Remove</button>
                         <button type="submit" class="btn btn-primary" id="connect_google" hidden>Connect</button>
                     </div>
    </div>


    <div id="regis" class="container tab-pane fade">
    <div class="row">
                                    <div class="col-md-5">
                                        <h3>New Facebook plateform</h3>
                                        <p>Set up the source of your reviews on Facebook!</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <h6>Enter your Page Username</h6>
                                    </div>
                                    <div class="col-md-8">
                                     <form>
                                      <div class="form-group">
                                        <div class="d-flex">
                                            <input type="text" class="form-control mr-2" id="fb_username" placeholder="Facebook Page Username">
                                            <button type="submit" id="load_fb_reviews" class="btn btn-primary">Load</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

    <hr>
    <div>
     <button type="submit" id="hide_fb_div" class="btn btn-cancel">Remove</button>
     <button type="submit" id="connect_fb" class="btn btn-primary" hidden>Connect</button>
    </div>
    </div>

    </div>

    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    @endif--}}
    <div class="form-section text-center">
        <div class="form-group">
            <label>*Contact Information </label>
            <p>Fill out the contact information you would like to provide.</p>
            <div class="row">
                <div class="col-12 col-md-12  col-lg-6 col-xl-6">
                    <div class="form-group icons-field"><img src="{{ asset('gymselect\images\icon1.jpg') }}">
                        {{ html()->text('links[website]', old('links.website', $links->website ?? ''))->class('form-control')->placeholder('Website url') }}
                    </div>
                </div>
                <div class="col-12 col-md-12  col-lg-6 col-xl-6">
                    <div class="form-group icons-field"><img src="{{ asset('gymselect\images\icon2.jpg') }}">
                        {{ html()->text('links[facebook]', old('links.facebook', $links->facebook ?? ''))->class('form-control')->placeholder('Facebook url') }}
                    </div>
                </div>
                <div class="col-12 col-md-12  col-lg-6 col-xl-6">
                    <div class="form-group icons-field"><img src="{{ asset('gymselect\images\icon3.jpg') }}">
                        {{ html()->text('links[phone]', old('links.phone', $links->phone ?? ''))->class('form-control')->placeholder('Phone number') }}
                    </div>
                </div>
                <div class="col-12 col-md-12  col-lg-6 col-xl-6">
                    <div class="input-group wp-field form-group">
                        <div class="input-group-prepend">
                            <img src="{{ asset('gymselect\images\icon9.png') }}">
                        </div>
                        {{ html()->select('links[whatsapp_code]', \App\Http\Helpers\AppHelper::CountryCode(), old('links.whatsapp_code', $links->whatsapp_code ?? ''))->class('form-control country-selector') }}
                        <div class="input-group-append col px-0">
                            {{ html()->text('links[whatsapp]', old('links.whatsapp', $links->whatsapp ?? ''))->class('form-control pl-3')->placeholder('Whatsapp number') }}
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12  col-lg-6 col-xl-6">
                    <div class="form-group icons-field"><img src="{{ asset('gymselect\images\icon4.jpg') }}">
                        {{ html()->text('links[instagram]', old('links.instagram', $links->instagram ?? ''))->class('form-control')->placeholder('Instagram url') }}
                    </div>
                </div>
                <div class="col-12 col-md-12  col-lg-6 col-xl-6">
                    <div class="form-group icons-field"><img src="{{ asset('gymselect\images\icon5.jpg') }}">
                        {{ html()->email('links[email]', old('links.email', $links->email ?? ''))->class('form-control')->placeholder('Email') }}
                    </div>
                </div>
                <div class="col-12 col-md-12  col-lg-6 col-xl-6">
                    <div class="form-group icons-field"><img src="{{ asset('gymselect\images\icon6.jpg') }}">
                        {{ html()->text('links[twitter]', old('links.twitter', $links->twitter ?? ''))->class('form-control')->placeholder('Twitter url') }}
                    </div>
                </div>
                <div class="col-12 col-md-12  col-lg-6 col-xl-6">
                    <div class="form-group icons-field"><img src="{{ asset('gymselect\images\icon8.png') }}">
                        {{ html()->text('links[linkedin]', old('links.linkedin', $links->linkedin ?? ''))->class('form-control')->placeholder('Linkedin url') }}
                    </div>
                </div>
                <div class="col-12 col-md-12  col-lg-6 col-xl-6">
                    <div class="form-group icons-field"><img src="{{ asset('gymselect\images\icon7.png') }}">
                        {{ html()->text('links[youtube]', old('links.youtube', $links->youtube ?? ''))->class('form-control')->placeholder('Youtube url') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-section text-center">
        <div class="form-group">
            <label>*Address </label>
            <p>Let users know where you will train them.</p>
            <p style="color:red;text-align:center;">*If you are an online coach and do not wish to share your home location, <br> simply enter your City and not your full address </p>
            <div class="row">
                <div class="col-12 col-md-12 col-lg-6 col-xl-6">
                    <div class="mb-3">
                        <div>Search location</div>
                        <div>
                            <div class="input-group">
                                <input type="text" id="address-autocomplete-input" placeholder="Type address here..." class="form-control shadow-sm" spellcheck="false" autocomplete="off" />
                                <div class="input-group-append">
                                    <button id="address-autocomplete-clear-btn" type="button" class="btn btn-outline-primary">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                            <div id="address-autocomplete-predictions" class="address-autocomplete-predictions d-none"></div>
                        </div>
                        <input type="hidden" id="address-autocomplete-latitude" name="address[latitude]" value="{{ old('address.latitude', @$address->latitude) }}" />
                        <input type="hidden" id="address-autocomplete-longitude" name="address[longitude]" value="{{ old('address.longitude', @$address->longitude) }}" />
                    </div>

                    <div class="form-group city">
                        {{ html()->text('address[city]', old('address.city', $address->city ?? ''))->class('form-control')->id('city')->placeholder('*Enter City') }}
                    </div>
                    <div class="form-group">
                        {{ html()->text('address[name]', old('address.name', $address->name ?? ''))->class('form-control')->id('street-number')->placeholder('Name / Number') }}
                    </div>
                    <div class="form-group">
                        {{ html()->text('address[street]', old('address.street', $address->street ?? ''))->class('form-control')->id('street')->placeholder('Street') }}
                    </div>
                    <div class="form-group">
                        {{ html()->text('address[country]', old('address.country', $address->country ?? ''))->class('form-control')->id('country')->placeholder('Country') }}
                    </div>
                    <div class="form-group">
                        {{ html()->text('address[postcode]', old('address.postcode', $address->postcode ?? ''))->class('form-control')->id('postcode')->placeholder('Postcode') }}
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-6 col-xl-6 d-flex align-items-end">
                    <div class="form-group text-left">
                        If possible, enter the name of the gym, club
                        or studio you are based at below.
                        <select class="form-control autoSelect" data-url="{{ route('autosearch.listing') }}" autocomplete="off" name="address[link_listing_id]"
                                placeholder="Enter name of facility"
                                data-default-text="{{ @$other_listings[$address->link_listing_id] }}"
                                data-default-value="{{ @$address->link_listing_id }}"
                        ></select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-section features-list accordion">
        <div class="form-group">
            <label>*Services</label>
            <p>Check all the services you offer.</p>
            <ul>
                @foreach($amenities as $feature)
                    <li>
                        <div class="custom-control custom-checkbox">
                            {{ html()->checkbox('amenities[]', in_array($feature->id, $amenityIds), $feature->id)->class('custom-control-input')->id("f_{$feature->id}") }}
                            <label class="custom-control-label" for="f_{{$feature->id}}"> {{$feature->name}}</label>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="form-section media-cont text-center">
        <div class="form-group">
            <label>Media </label>
            <p>Upload images that will showcase what you do. We recommend images of you training
                your clients.
            </p>
            <div class="wrapper media-uploads">
                <div id="mediaDropzone" class="file-upload fallback dropzone">
                    <div class="dz-message" data-dz-message><i class="fas fa-plus" aria-hidden="true"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-section about text-center">
        <div class="form-group">
            <label>About </label>
            <p>Tell us about your services, what makes you great and why people should come to you.</p>
            <div class="form-group">
                {{ html()->textarea('listing[about]', old('listing.about', $listing->about))->rows(3)->class('form-control') }}
            </div>
        </div>
    </div>
    <div class="form-section media-cont text-center">
        <div class="form-group">
            <label>Results </label>
            <p>Upload images that will showcase your results.</p>
            <p><span class="text-danger"> *Use images that are the same shape. We recommend using square photos when showcasing transformations.</p>
            <div class="wrapper">
                <div class="file-upload media" id="upload-holder-result">
                    {{ html()->file('result[]')->id('result')->multiple() }}
                    <i class="fas fa-plus" aria-hidden="true"></i></div>
            </div>
        </div>
    </div>
    <div class="form-section hours about text-center">
        <div class="form-group">
            <label>Qualifications</label>
            <p>Enter your qualifications below.</p>
            <div class="row">
                <div class="col-12 col-md-12 col-lg-6 col-xl-6 offset-xl-3 p-0  upload-qualification">
                    <div class="form-group">
                        {{-- <p> <input type="text" class="form-control" placeholder="e.g. Level 3 Personal Trainer"> </p> --}}
                        {{ html()->text('qualification_options[name][]', old('qualification_options.name.0'))->class('form-control')->placeholder('e.g. Level 3 Personal Trainer') }}
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-6 col-xl-6 offset-xl-3 p-0">
                    <div class="form-group">
                        <button type="button" class="btn btn2 btn-block btn-qualification" onclick=""><i
                                class="fas fa-plus" aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-section hours about text-center">
        <div class="form-group">
            <label>Options</label>
            <p class="mb-0">Enter your options below.</p>
            <p style="color:red;float:center;">*Leave this section blank if you do not want to show your prices. </p>

            <div class="row pr-3 row-eq-height">
                <div class="col-12 col-md-6 col-lg-6 col-xl-6 mt-4 pr-0 upload-membership">
                    <div class="wrapper">
                        <div class="file-upload media  user-upload" id="upload-holder-membership">
                            <button type="button" class="btn btn2 btn-block btn-membership">
                                <i class="fas fa-plus" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @php
                    $random_id = uuid_create();
                @endphp
                <div class="col-12 col-md-6  col-lg-6 col-xl-6 mt-4 pr-0 append-section" data-uid="{{$random_id}}">
                    <div class="new-options-container">
                        <div class="new-options-heading"> Options</div>
                        <div class="member-plan">
                            <input class="form-control" placeholder="Name e.g. Gold Plan" name="membership_options[{{$random_id}}][name]" type="text">
                        </div>
                        <div class="member-plan">
                            <input class="form-control" placeholder="Price e.g. £300 p/m" name="membership_options[{{$random_id}}][price]" type="text">
                        </div>
                        <div class='member-includes'>
                            <div class="btn btn2 btn-block">What does this include?</div>
                            <div class="member-includes-list">
                                <ul>
                                    <li class="append-section">
                                        <input class="form-control plan-includes" placeholder="e.g. 3 PT Sessions p/w" name="membership_options[{{$random_id}}][includes][]" type="text">
                                        <i class="fas fa-times close-section" aria-hidden="true"></i>
                                    </li>
                                </ul>
                                <button type="button" class="btn btn2 btn-block btn-includes"><i class="fas fa-plus" aria-hidden="true"></i></button>
                            </div>
                        </div>
                        <i class="fas fa-times close-section" aria-hidden="true"></i>
                    </div>
                </div>
                <div class="d-none">
                    <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="sign-member">
                            <h5>Do you have a signup/membership page? Enter the url so that potential members can sign up to
                                your facility</h5>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-7 col-xl-7">
                        <div class="form-group mt-4">
                            {{ html()->text('listing[signup_url]', old('listing.signup_url', $listing->signup_url))->class('form-control')->placeholder('Website Page URL') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<div class="row">
    <div class="col-12 col-md-12 col-lg-10 col-xl-6 offset-xl-3 mt-4">
        <button type="button" class="btn btn2 btn-dark btn-block border-radius"
                onClick="javascript:finish_step('save');">{{ request()->routeIs('business.edit') ? 'Update' : 'Save' }} Listing
        </button>
        @if(!$listing->published)
            <button type="button" class="btn btn2 btn-block  border-radius" onclick="javascript:finish_step('publish');">Publish Listing</button>
        @else
            <button type="button" class="btn btn2 btn-block  border-radius" onclick="javascript:finish_step('unpublish');">Unpublish Listing</button>
        @endif
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                <p class="text-left"><strong>Step 1 - </strong>Visit link <a href="https://developers.google.com/maps/documentation/javascript/examples/places-placeid-finder" target="_blank">here. </a></p>
                <p class="text-left"><strong>Step 2 -</strong> Enter your business location. A location drop pin will display your Place ID.</p>
                <p><img src="{{ asset('images\pid_1.png') }}"></p>
                <p class="text-left"><strong>Step 3 - </strong>Copy the Place ID: xxxxxxxxxxxxxxxxxxxx and you will need to <strong>paste</strong> it in the input field. </p>
                <p><img src="{{ asset('images\pid_2.png') }}"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="subs_close">Close</button>
            </div>
        </div>

    </div>
</div>

@push('footer_scripts')
<script type="text/javascript">
    var service = null;

    function updateFormFields(addressParts, lat, lang){
        var input = document.getElementById('address-autocomplete-input');
        if(input) {
            input.value = '';
        }
        var addrLatitude = document.getElementById('address-autocomplete-latitude');
        var addrLongitude = document.getElementById('address-autocomplete-longitude');
        if(addrLatitude) {
            addrLatitude.value = lat;
        }
        if(addrLongitude) {
            addrLongitude.value = lang;
        }
        var addrCountry = document.getElementById('country');
        if(addrCountry) {
            addrCountry.value = (addressParts?.country?.length) ? addressParts.country : '';
        }
        var addrCity = document.getElementById('city');
        if(addrCity) {
            addrCity.value = (addressParts?.city?.length) ? addressParts.city : '';
        }
        var addrPostcode = document.getElementById('postcode');
        if(addrPostcode) {
            addrPostcode.value = (addressParts?.postalCode?.length) ? addressParts.postalCode : '';
        }
        var addrStreet = document.getElementById('street');
        if(addrStreet) {
            addrStreet.value = (addressParts?.street?.length) ? addressParts.street : '';
        }
        var addrStreetNumber = document.getElementById('street-number');
        if(addrStreetNumber) {
            addrStreetNumber.value = '';
        }
    }

    function getAddressComponents(address){
        var components = [];
        try {
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({'address': address}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    components = results[0]['address_components'];
                    var lat = results[0].geometry.location.lat();
                    var lang = results[0].geometry.location.lng();
                    var addressParts = getAddressComponentsValue(components);
                    if(!addressParts.city.length) {
                        toast.error('City is required in address');
                    } else if(!addressParts.country.length) {
                        toast.error('Country is required in address');
                    } else {
                        updateFormFields(addressParts, lat, lang);
                    }
                }
            });
        } catch (e) {
            console.log(e);
        }
    }

    function handleAddressSelection(input, predictions){
        var input = document.getElementById('address-autocomplete-input');
        var predictions = document.getElementById('address-autocomplete-predictions');
        predictions?.addEventListener('click', function(e){
            if(e?.target?.classList.contains('address-autocomplete-prediction')) {
                predictions.classList.add('d-none');
                getAddressComponents(e.target.textContent);
                while (predictions.firstChild) {
                    predictions.removeChild(predictions.lastChild);
                }
            }
        });
    }

    function addressAutocompleteCallback(predictions, status, predictionsEl){
        if (status != google.maps.places.PlacesServiceStatus.OK) {
            return;
        }
        if(predictions.length){
            predictionsEl.classList.remove('d-none');
            while (predictionsEl.firstChild) {
                predictionsEl.removeChild(predictionsEl.lastChild);
            }
            for (var i = 0, prediction; prediction = predictions[i]; i++) {
                var div = document.createElement('div');
                var higlightedString = makeAddressSectionsBold(prediction.description, prediction.matched_substrings);
                div.innerHTML = higlightedString;
                div.classList.add('address-autocomplete-prediction', 'text-left');
                predictionsEl.appendChild(div);
            }
        } else {
            predictionsEl.classList.add('d-none');
        }
    }


    function setupAutocompleteAddressInput() {
        var autocompleteAddressInput = document.getElementById('address-autocomplete-input');
        var autocompleteAddressPredictions = document.getElementById('address-autocomplete-predictions');
        if(autocompleteAddressInput && autocompleteAddressPredictions) {
            handleAddressSelection();
            autocompleteAddressInput.addEventListener('keyup', debouncer(function(e){
                var request = { input: e.target.value };
                if( !e.target.value.trim() ) {
                    autocompleteAddressPredictions.classList.add('d-none');
                    while (autocompleteAddressPredictions.firstChild) {
                        autocompleteAddressPredictions.removeChild(autocompleteAddressPredictions.lastChild);
                    }
                }
                service.getPlacePredictions(request, function(predictions, status){
                    addressAutocompleteCallback(predictions, status, autocompleteAddressPredictions);
                });
            }, 500))

            var addressAutocompleteClearBtn = document.getElementById('address-autocomplete-clear-btn');
            if(addressAutocompleteClearBtn) {
                addressAutocompleteClearBtn.addEventListener('click', function(){
                    var autocompleteAddressPredictions = document.getElementById('address-autocomplete-predictions');
                    if(autocompleteAddressPredictions) {
                        autocompleteAddressPredictions.classList.add('d-none');
                    }
                    var autocompleteAddressInput = document.getElementById('address-autocomplete-input');
                    if(autocompleteAddressInput) {
                        autocompleteAddressInput.value = '';
                    }
                });
            }
        }
    }

    function initMap(){
        try {
            setTimeout(function(){
                service = new google.maps.places.AutocompleteService();
                setupAutocompleteAddressInput();
            }, 4000);
            // updateBoostedCitiesRow();
        } catch (e){
            console.log(e);
        }
    }


    // var searchField = jQuery('#city');
    // function getLatLng(address) {
    //     console.log(address);
    //     var geocoder = new google.maps.Geocoder();
    //     geocoder.geocode({'address': address}, function (results, status) {
    //         if (status == google.maps.GeocoderStatus.OK) {
    //             posField.val(`${results[0].geometry.location.lat()},${results[0].geometry.location.lng()}`);
    //         }
    //     });
    // }
    // function initMap() {
    //     var searchAutoComplete = new google.maps.places.Autocomplete(searchField.get(0), {
    //         types: ['geocode'],
    //         componentRestrictions: {country: 'uk'}
    //     });
    //     google.maps.event.addListener(searchAutoComplete, 'place_changed', function () {
    //         getLatLng(searchField.val());
    //     });
    // }
    // setTimeout(() => {
        // jQuery('#city').removeAttr('autocomplete');
    // }, 1000);

    //      document.addEventListener("DOMContentLoaded", function(event) {
    // setTimeout(() => {
    //     $('#hide_div').on('click', function (event) {
    //         event.preventDefault();
    //      $('#nav nav-pills').removeClass("active");
    //      $('#login').removeClass("active");
    //     });
    //     $('#hide_fb_div').on('click', function (event) {
    //         event.preventDefault();
    //      $('#nav nav-pills').removeClass("active");
    //      $('#regis').removeClass("active");
    //     });
    //     $('#load_fb_reviews').on('click', function (event) {
    //         event.preventDefault();
    //         $("#load_fb_reviews").html("Loading").attr('disabled', 'disabled');

    //         let fb_username=$('#fb_username').val();
    //         let listing_id=<?php echo $listing->id ?>;
    //         $.ajax({
    //         type: "POST",
    //         url: "/load/fb_rev",
    //         data:{
    //             fb_username:fb_username,
    //             listing_id:listing_id
    //         },
    //         success: function(data,status){
    //             if(data=="Loaded")
    //                     {

    //                         $('#fb_username').css("border", "1px solid green");
    //                         $("#load_fb_reviews").html("Loaded");
    //                         $("#load_fb_reviews").addClass('btn btn-success').removeClass('btn btn-primary');
    //                         $('#connect_fb').removeAttr('hidden');
    //                     }
    //                     else
    //                     {
    //                         $('#fb_username').css("border", "1px solid red");
    //                     }
    //         }

    //     });
    //     });

    //     $('#load_google_reviews').on('click', function (event) {
    //         event.preventDefault();
    //         $("#load_google_reviews").html("Loading").attr('disabled', 'disabled');;
    //         let place_id= $('#InputName').val();
    //         let listing_id=<?php echo $listing->id ?>;
    //         $.ajax({
    //         type: "POST",
    //         url: "/load/google_rev",
    //         data:{
    //             place_id:place_id,
    //             listing_id:listing_id
    //         },
    //         success: function(data,status){
    //             if(data=="Loaded")
    //                     {

    //                         $('#InputName').css("border", "1px solid green");
    //                         $("#load_google_reviews").html("Loaded");
    //                         $("#load_google_reviews").addClass('btn btn-success').removeClass('btn btn-primary');
    //                         $('#connect_google').removeAttr('hidden');
    //                     }
    //                     else
    //                     {
    //                            $('#InputName').css("border", "2px solid red");
    //                     }
    //         }

    //     });
    //     });
    //     $('#connect_fb').on('click', function (event) {
    //         event.preventDefault();
    //         $.ajax({
    //             type: "POST",
    //             url: "/connect/fb",
    //             data:{},
    //             success: function(data,status)
    //     {
    //         $('#regis').append(data);

    //         $('.all').on('click', function (event) {
    //             event.preventDefault();
    //             $('.five').removeClass( "active" );
    //             $('.fourfive').removeClass( "active" );
    //             $('.all').addClass( "active" );
    //         });
    //         $('.five').on('click', function (event) {
    //             event.preventDefault();
    //             $('.all').removeClass( "active" );
    //             $('.fourfive').removeClass( "active" );
    //             $('.five').addClass( "active" );
    //         });
    //         $('.fourfive').on('click', function (event) {
    //             event.preventDefault();
    //             $('.all').removeClass( "active" );
    //             $('.five').removeClass( "active" );
    //             $('.fourfive').addClass( "active" );
    //         });
    //         $('#fb_rev_del_confirm').on('click', function (event) {
    //             event.preventDefault();
    //             $('#delfbrev').modal('hide');
    //             let brand="F API";
    //             $.ajax({
    //                 type: "POST",
    //                 url: "/delete/reviews",
    //                 data:{brand:brand},
    //                 success: function(data,status)
    //                 {
    //                         if(data=="F API Brand Reviews Deleted Successfully")
    //                         {
    //                             $('#fb_review_table').hide();
    //                         }
    //                 }
    //             });
    //         });
    //         $('#save_listing').on('click', function (event) {
    //             event.preventDefault();
    //         if ($('.all').hasClass("active"))
    //         {
    //             let filter_val="All";
    //             $.ajax({
    //                 type: "POST",
    //                 url: "/save/filter",
    //                 data:{filter_val:filter_val},
    //                 success: function(data,status)
    //                 {

    //                 }
    //             });
    //         }
    //         else if ($('.five').hasClass("active"))
    //         {
    //             let filter_val="Five";
    //             $.ajax({
    //                 type: "POST",
    //                 url: "/save/filter",
    //                 data:{filter_val:filter_val},
    //                 success: function(data,status)
    //                 {

    //                 }
    //             });
    //         }
    //         else if ($('.fourfive').hasClass("active"))
    //         {
    //             let filter_val="Four&Five";
    //             $.ajax({
    //                 type: "POST",
    //                 url: "/save/filter",
    //                 data:{filter_val:filter_val},
    //                 success: function(data,status)
    //                 {

    //                 }
    //             });
    //         }

    //     });
    //     }
    //         });
    //     });
    //     $('#connect_google').on('click', function (event) {
    //         event.preventDefault();
    //         $.ajax({
    //             type: "POST",
    //             url: "/connect/google",
    //             data:{},
    //             success: function(data,status)
    //     {
    //         $('#login').append(data);

    //         $('.all').on('click', function (event) {
    //             event.preventDefault();
    //             $('.five').removeClass( "active" );
    //             $('.fourfive').removeClass( "active" );
    //             $('.all').addClass( "active" );
    //         });
    //         $('.five').on('click', function (event) {
    //             event.preventDefault();
    //             $('.all').removeClass( "active" );
    //             $('.fourfive').removeClass( "active" );
    //             $('.five').addClass( "active" );
    //         });
    //         $('.fourfive').on('click', function (event) {
    //             event.preventDefault();
    //             $('.all').removeClass( "active" );
    //             $('.five').removeClass( "active" );
    //             $('.fourfive').addClass( "active" );
    //         });
    //         $('#google_rev_del_confirm').on('click', function (event) {
    //             event.preventDefault();
    //             $('#delgooglerev').modal('hide');
    //             let brand="G API";
    //             $.ajax({
    //                 type: "POST",
    //                 url: "/delete/reviews",
    //                 data:{brand:brand},
    //                 success: function(data,status)
    //                 {
    //                         if(data=="G API Brand Reviews Deleted Successfully")
    //                         {
    //                             $('#google_review_table').hide();
    //                         }
    //                 }
    //             });
    //         });
    //         $('#save_listing').on('click', function (event) {
    //             event.preventDefault();
    //         if ($('.all').hasClass("active"))
    //         {
    //             let filter_val="All";
    //             $.ajax({
    //                 type: "POST",
    //                 url: "/save/filter",
    //                 data:{filter_val:filter_val},
    //                 success: function(data,status)
    //                 {

    //                 }
    //             });
    //         }
    //         else if ($('.five').hasClass("active"))
    //         {
    //             let filter_val="Five";
    //             $.ajax({
    //                 type: "POST",
    //                 url: "/save/filter",
    //                 data:{filter_val:filter_val},
    //                 success: function(data,status)
    //                 {

    //                 }
    //             });
    //         }
    //         else if ($('.fourfive').hasClass("active"))
    //         {
    //             let filter_val="Four&Five";
    //             $.ajax({
    //                 type: "POST",
    //                 url: "/save/filter",
    //                 data:{filter_val:filter_val},
    //                 success: function(data,status)
    //                 {
    //                 }
    //             });
    //         }
    //     });
    //     }
    //         });
    //     });
    // }, 1000);
    // });
</script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_GEOLOCATION_API') }}&libraries=places&loading=async&callback=initMap"></script>
@endpush
