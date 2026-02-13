<?php

namespace App\Http\Controllers;

use App\Events\ListingCreated;
use App\Events\RequestBoost;
use App\Events\RequestVerification;
use App\Events\UserRegistered;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Http\Helpers\AppHelper;
use App\Http\Requests\Web\AccountRequest;
use App\Http\Requests\Web\ContactRequest;
use App\Http\Requests\Web\JoinBusinessRequest;
use App\Http\Requests\Web\JoinPersonalRequest;
use App\Http\Requests\Web\ReportAbuseRequest;
use App\Http\Requests\Web\ReviewRequest;
use App\Http\Requests\Web\SearchBusinessRequest;
use App\LocationBoostPlan;
use App\Mail\Notification;
use App\Mail\ReportAbuseNotification;
use App\Models\AmenityListing;
use App\Models\Boost;
use App\Models\Business;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Faq;
use App\Models\FileVerification;
use App\Models\Invoice;
use App\Models\Listing;
use App\Models\ListingAddress;
use App\Models\ListingLink;
use App\Models\ListingMedia;
use App\Models\ListingMembership;
use App\Models\ListingQualification;
use App\Models\ListingResult;
use App\Models\ListingReview;
use App\Models\ListingTeam;
use App\Models\ListingVerification;
use App\Models\LocationBoostCity;
use App\Models\Notification as NotificationModel;
use App\Models\Partner;
use App\Models\Plan;
use App\Models\ReportAbuse;
use App\Models\Setting;
use App\Models\User;
use App\Models\Verification;
use Auth;
use Carbon\Carbon;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Facebook\Facebook;
use Facebook\FacebookResponse;
use App\Models\Sponsors;
use App\Models\Subscription;
use App\Models\Towns;

class HomePageController extends Controller
{
    use FileUploadTrait;
    public function index()
    {
        $sponsors = Sponsors::get();
        return view('mainTable.index',compact('sponsors'));
    }

    public function personalRegister()
    {
        return view('mainTable.personal_register');
    }

    public function storePersonalUser(JoinPersonalRequest $request)
    {
        try {
            $request = $this->saveFiles($request);
            $data = $request->except(['_token', 'password_confirmation']);
            $data['verify_token'] = uuid_create();
            $data['status'] = 0;
            $user = User::create($data);
            event(new UserRegistered($user));
            alert()->success('Please check your inbox and spam folder for our activation email!')->persistent('OK');
            return redirect()->route('home');
        } catch (\Exception $e) {
            alert()->error($e->getMessage());
            return redirect()->back();
        }
    }
    public function selectBusiness(Request $request)
    {
        $data['type'] = strtolower($request->get('biz'));
        if ($data['type']) {
            $data['videoURL'] = Business::VIDEOS[$data['type']];
        }

        return view('mainTable.business_choose', $data);
    }

    public function businessRegister($type = null, $status = null)
    {
        $data['editBiz'] = false;
        $data['id'] = $data['listing'] = $data['saveRoute'] = null;
        if (request()->route()->getName() == 'business.edit') {
            $data['editBiz'] = true;
            $type = strtolower(auth()->user()->business->name);
            $data['listing'] = Listing::where('user_id', $data['id'])->orderBy('created_at', 'DESC')->first();
        } elseif (request()->route()->getName() == 'admin.business.edit') {
            $data['editBiz'] = true;
            $data['listing'] = Listing::with('business')->find($type);
            $data['saveRoute'] = ["admin.business.store", $type];
            $type = strtolower($data['listing']->business->name);
            $data['id'] = $data['listing']->user_id;
        }
        if (!$type && auth()->check()) {
            if (auth()->user()->listing) {
                return redirect()->route('business.edit');
            } else {
                return redirect()->route('home');
            }
        }

        $data['type'] = $type;
        if (!$data['saveRoute']) {
            $data['saveRoute'] = ["store.business.user", $type];
        }

        $data['memberships'] = $data['qualifications'] = [];
        list($data['titles'], $data['placeholder']) = AppHelper::businessTitles($type);
        if ($data['editBiz']) {
            $data['titles'][3] = [
                'title' => 'Edit Listing',
                'subtitle' => ''
            ];
        }
        $business = $data['business'] = Business::where('name', $type)->first();
        $data['plans'] = Plan::where('business_id', $business->id)->get();
        $data['media'] = [];
        $data['teams'] = [];
        $data['results'] = [];
        if (auth()->check()) {
            if (!$data['id']) {
                $data['id'] = auth()->user()->id;
            }
            $data['categories'] = $business->categories()->pluck('name', 'id');
            $data['other_listings'] = Listing::where('user_id', '<>', $data['id'])->get()->pluck('name', 'id')->toArray();
            $data['amenities'] = $business->amenities;
            if (!$data['listing']) {
                $data['listing'] = Listing::firstOrNew(['user_id' => $data['id']]);
                if (!$data['listing']->business_id) {
                    $data['listing']->business_id = $business->id;
                }
            }
            $data['links'] = $data['listing']->links;
            $data['address'] = $data['listing']->address ?: new ListingAddress();
            $data['based_profile'] = $data['address']->listing();


            $data['amenityIds'] = $data['listing']->amentities()->pluck('amenity_id')->toArray() ?: [];
            $data['memberships'] = $data['listing']->memberships()->get()->toArray() ?: [];
            $data['qualifications'] = $data['listing']->qualifications->pluck('name')->toArray() ?: [];
            $data['media'] = $data['listing']->media->pluck("file_path")->toArray() ?: [];
            $data['results'] = $data['listing']->results->pluck("file_path")->toArray() ?: [];
            $teams = $data['listing']->teams;

            if ($teams->count()) {
                foreach ($teams as $team) {
                    $row = $team->only(['name', 'job', 'user_id', 'file_path']);
                    $row['user_name'] = $team->user_id ? @$team->user->listing->name : '';
                    $data['teams'][] = $row;
                }
            }
        }
        $data['coupons'] = Coupon::active()->whereHas('business', function ($query) use ($type) {
            $query->where('businesses.name', $type);
        })->limit(1)->get();
        $data['view'] = AppHelper::isMobile() ? true : false;
        return view("mainTable.business_register", $data);
    }

    public function validateBusinessForm(JoinBusinessRequest $request, $type = null)
    {
        return response()->json(true);
    }

    public function storeBusinessUser(JoinBusinessRequest $request, $type)
    {
        if (auth()->guest()) {
            $business = Business::where('name', $type)->first();

            $frequency = ($request->frequency == 'monthly') ? 'M' : 'Y';
            $plan = Plan::where(['business_id' => $business->id, 'frequency' => $frequency])->first();

            //Coupon
            $coupon = null;
            if ($code = $request->coupon_code) {
                $coupon = Coupon::getCouponByCode($code, $business->id, $plan->price, $request->frequency);

                if (!$coupon) {
                    alert()->error('This coupon is invalid');
                    return redirect()->route('join.business', [$type])->withInput();
                }
            }

            //User
            $user = new User($request->except(['_token', 'password_confirmation']));
            $user->role_id = User::ROLE_BUSINESS_USER;
            $user->business_id = $business->id;
            $user->save();

            try {
                $user->createAsStripeCustomer([
                    'name' => $user->name,
                    'address' => [
                        'line1' => $user->address_line_1,
                        'line2' => $user->address_line_2,
                        'city' => $user->city,
                        'postal_code' => $user->postal_code,
                    ]
                ]);

            } catch (\Exception $e) {
                $user->forceDelete();
                return response()->json(['message' => $e->getMessage()], 422);
            }

            //Subscription
            $subscriptionBuilder = $user->newSubscription('default', $plan->plan_id);

            //Apply coupon
            if ($coupon) {
                $subscriptionBuilder->withCoupon($coupon->stripe_id);
            }

            //Apply freetrial
            if ($free_trial = $plan->free_trial) {
                $subscriptionBuilder->trialDays((int)$free_trial);
            }

            try {
                $subscriptionBuilder->create($request->paymentMethod);
                if ($coupon) {
                    $user->coupon_id = $coupon->id;
                    $user->save();
                    $coupon->increment('redemptions');
                }
                \Auth::login($user);
                $returnUrl = route('join.business', [$type, 'success']);
                return response()->json(['message' => 'User registration completed successfully!', 'returnUrl' => $returnUrl], 200);
            } catch (\Exception $e) {
                $stripeCustomer = $user->asStripeCustomer();
                if ($stripeCustomer) {
                    $stripeCustomer->delete();
                }
                $user->forceDelete();
                return response()->json(['message' => $e->getMessage()], 422);
            }
        }
        if (request()->route()->getName() == 'store.business.user') {
            $listing = Listing::firstOrNew(['user_id' => auth()->user()->id]);
            $business = Business::where('name', $type)->first();
        } elseif (request()->route()->getName() == 'admin.business.store') {
            $listing = Listing::find($type);
            $business = $listing->business;
        }
        $request = $this->saveFiles($request);
        $listing->fill($request->get('listing'));
        $listing->business_id = $business->id;
        if ($request->mode == 'publish') {
            $listing->published = 1;
        } elseif ($request->mode == 'unpublish') {
            $listing->published = 0;
        }

        $listing->save();
        $links = $request->get('links', []);
        $listingLink = ListingLink::firstOrNew(['listing_id' => $listing->id]);
        $listingLink->fill($links);
        $listingLink->save();


        if ($address = array_filter($request->get('address'))) {
            $listingAddress = ListingAddress::firstOrNew(['listing_id' => $listing->id]);
            if(empty($address['name'])) {
                $address['name'] = '';
            }
            if(empty($address['street'])) {
                $address['street'] = '';
            }
            if(empty($address['postcode'])) {
                $address['postcode'] = '';
            }
            $listingAddress->fill($address);
            $listingAddress->save();
        }

        //Save features
        $listing->amentities()->sync($request->amenities);

        //Save media files
        $oldMedias = $listing->media;
        $oldMediaFiles = [];
        if ($oldMedias) {
            $oldMediaFiles = $oldMedias->pluck('file_path')->toArray();
        }
        $newMedias = array_filter($request->get('media', []));
        $toBeDelete = array_diff($oldMediaFiles, $newMedias);
        if ($toBeDelete) {
            ListingMedia::where('listing_id', $listing->id)->whereIn('file_path', $toBeDelete)->delete();
        }

        if ($newMedias) {
            foreach ($newMedias as $media) {
                ListingMedia::firstOrCreate(['listing_id' => $listing->id, 'file_path' => $media]);
            }
        }

        //Edit Media
        if ($mediasEdit = @$request->media_edit) {
            foreach ($mediasEdit as $media) {
                if ($media) {
                    ListingMedia::create(['listing_id' => $listing->id, 'file_path' => $media]);
                }
            }
        }

        //Save mebership plans
        $listing->memberships()->delete();
        if ($options = $request->get('membership_options')) {
            foreach ($options as $option) {
                $values = array_filter(['name' => $option['name'], 'price' => filter_var($option['price']), 'includes' => filter_var_array($option['includes'])]);
                if ($values) {
                    $values['listing_id'] = $listing->id;
                    ListingMembership::create($values);
                }
            }
        }

        //Save team data
        $listing->teams()->delete();
        if ($newTeams = $request->get('team')) {
            $count = count($newTeams['name']);
            for ($i = 0; $i < $count; $i++) {
                $values = array_filter(['name' => $newTeams['name'][$i], 'job' => $newTeams['job'][$i], 'user_id' => $newTeams['user_id'][$i], 'file_path' => @$newTeams['file_path'][$i]]);
                if ($values) {
                    $values['listing_id'] = $listing->id;
                    ListingTeam::create($values);
                }
            }
        }

        //Edit team data
        if ($oldTeams = $request->get('team_edit')) {
            foreach ($oldTeams['name'] as $index => $value) {
                $values = array_filter([
                    'name' => @$value,
                    'job' => @$oldTeams['job'][$index],
                    'user_id' => @$oldTeams['user_id'][$index],
                ]);
                if (@$oldTeams['file_path'][$index]) {
                    $values['file_path'] = @$oldTeams['file_path'][$index];
                } elseif (@$oldTeams['old_file_path'][$index]) {
                    $values['file_path'] = @$oldTeams['old_file_path'][$index];
                }
                if ($values) {
                    $values['listing_id'] = $listing->id;
                    ListingTeam::create($values);
                }
            }
        }
        //Save result data
        $listing->results()->delete();
        if ($results = @$request->result) {
            foreach ($results as $result) {
                ListingResult::create(['listing_id' => $listing->id, 'file_path' => $result]);
            }
        }

        //Edit result data
        if ($resultEdit = @$request->result_edit) {
            foreach ($resultEdit as $result) {
                ListingResult::create(['listing_id' => $listing->id, 'file_path' => $result]);
            }
        }

        //Save qualification
        $listing->qualifications()->delete();
        $options = $request->get('qualification_options');
        if ($options) {
            $count = count($options['name']);
            for ($i = 0; $i < $count; $i++) {
                $values = array_filter(['name' => $options['name'][$i]]);
                if ($values) {
                    $values['listing_id'] = $listing->id;
                    ListingQualification::create($values);
                }
            }
        }

        $returnUrl = route('business.edit');
        if (request()->route()->getName() == 'admin.business.store') {
            $returnUrl = route('admin.business.edit', $type);
        }
        if ($request->mode == "save") {
            $returnMsg = "Listing saved successfully!!";
        } else if ($request->mode == "publish") {
            $returnMsg = "Listing published successfully!!";
            $returnUrl = route('listing.view', [$listing->slug]);
        } else {
            $returnMsg = "Listing Unpublished successfully!!";
        }

        if ($request->ajax()) {
            return response()->json(['message' => $returnMsg, 'returnUrl' => $returnUrl], 200);
        }
        alert()->success($returnMsg);
        return redirect($returnUrl);
    }

public function get_facebook_reviews()
{
    $listings=Listing::all();
    $fb_api_key= env("FACEBOOK_API_KEY");
    foreach($listings as $listing)
        {
            $reviews=[];
            $fb_username=($listing["fb_username"]!=NULL)?$listing["fb_username"]:'not found';
            if($fb_username != "not found")
            {
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://wextractor.com/api/v1/reviews/facebook?auth_token=".$fb_api_key."&id=".$fb_username."",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30000,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => array(
                        "accept: */*",
                        "accept-language: en-US,en;q=0.8",
                        "content-type: application/json",
                    ),
                ));
                $response = curl_exec($curl);
                $res=json_decode($response);

                if(isset($res->reviews))
                {
                    $reviews=array_merge($reviews,$res->reviews);
                    $cursor=$res->next_page_cursor;
                    while(isset($cursor))
                    {
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => "https://wextractor.com/api/v1/reviews/facebook?auth_token=".$fb_api_key."&id=".$fb_username."&cursor=".$cursor."",
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => "",
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 30000,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => "GET",
                            CURLOPT_HTTPHEADER => array(
                                "accept: */*",
                                "accept-language: en-US,en;q=0.8",
                                "content-type: application/json",
                            ),
                        ));
                        $response = curl_exec($curl);
                        $res2=json_decode($response);
                        $reviews=array_merge($reviews,$res2->reviews);
                        curl_close($curl);
                        if(isset($res2->reviews)){
                            $cursor=$res2->next_page_cursor;
                        }else{
                            $cursor = null;
                        }
                    }
                    foreach($reviews as $review)
                    {
                        if($review->recommends_rating=="recommends")
                        {
                            $listing_review = [
                                'updated_at' => Carbon::now(),
                                'created_at' => Carbon::now(),
                                'user_id' => $listing->user_id,
                                'user_name' => $review->reviewer,
                                'listing_id' => $listing->id,
                                'message' => $review->text,
                                'rating' => '5',
                                'brand' => 'F API'
                            ];
                           ListingReview::where("listing_id",$listing->id)->where('user_name',$review->reviewer)->delete();
                           ListingReview::insert($listing_review);
                        }
                    }

                }
            }
        }
        return response("Reviews Added Successfully");
}
public function load_fb_rev(Request $request)
{
    $reviews = [];
    if(isset($request->listing_id))
    {
        $listing=Listing::where('id',$request->listing_id)->with('user')->get();
    }
    else
    {
    $user = Auth::user();
    $listing=Listing::where('user_id',$user->id)->with('user')->get();
    }
    $fb_username=str_replace('.','%2E',$request->fb_username);
    $api_key= env("FACEBOOK_API_KEY");
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://wextractor.com/api/v1/reviews/facebook?auth_token=".$api_key."&id=".$fb_username."",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30000,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "accept: */*",
            "accept-language: en-US,en;q=0.8",
            "content-type: application/json",
        ),
    ));
    $response = curl_exec($curl);
    $res=json_decode($response);
    if(isset($res->reviews))
    {
        $reviews=array_merge($reviews,$res->reviews);
        // var_dump($reviews);
        $cursor=$res->next_page_cursor;
        // var_dump($remaining);
        Session()->put('fb_load_data',['listing_id' => $listing[0]["id"],'user_id' => $listing[0]["user_id"],'totals' => $res->totals,
        'fb_username' => $fb_username ,'fb_reviews' => $reviews,'cursor' => $cursor] );
        return response("Loaded");
    }
    else
        return response("Error");
}
public function fb_connect(Request $request)
{
    $fb_load_data=Session()->get('fb_load_data');
    $api_key= env("FACEBOOK_API_KEY");
    if(isset($fb_load_data))
    {
    $reviews = $fb_load_data["fb_reviews"];
    $cursor=$fb_load_data["cursor"];
    $fb_username=$fb_load_data["fb_username"];
    while(isset($cursor))
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://wextractor.com/api/v1/reviews/facebook?auth_token=".$api_key."&id=".$fb_username."&cursor=".$cursor."",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "accept: */*",
                "accept-language: en-US,en;q=0.8",
                "content-type: application/json",
            ),
        ));
        $response = curl_exec($curl);
        $res2=json_decode($response);
        $reviews=array_merge($reviews,$res2->reviews);
        curl_close($curl);
        if(isset($res2->reviews)){
            $cursor=$res2->next_page_cursor;
        }else{
            $cursor = null;
        }
    }
    foreach($reviews as $review){
        if($review->recommends_rating=="recommends")
        {
        if($review->text=="")
        {
            $listing_review = [
                'user_id'    => $fb_load_data["user_id"],
                'user_name'  => $review->reviewer,
                'listing_id' => $fb_load_data["listing_id"],
                'message'    => "Highly Recommended",
                'rating'     => '5',
                'brand'      => 'F API'
            ];
        }
        else
        {
        $listing_review = [
            'user_id'    => $fb_load_data["user_id"],
            'user_name'  => $review->reviewer,
            'listing_id' => $fb_load_data["listing_id"],
            'message'    => $review->text,
            'rating'     => '5',
            'brand'      => 'F API'
        ];
        }
        $listing=
        [
            'fb_username' => $fb_load_data["fb_username"],
            'avg_fb_rating' => $fb_load_data["totals"]->average_rating
        ];
        ListingReview::updateOrCreate($listing_review);
        Listing::where('id',$fb_load_data["listing_id"])->update($listing);
        }
    }
    $listing=Listing::where('id',$fb_load_data["listing_id"])->get();
    $listing_address=ListingAddress::where('listing_id',$listing[0]->id)->get();
    $address="".$listing_address[0]->name." ".$listing_address[0]->street." ".$listing_address[0]->city."";

        return response("<div class='review_display text-center'>
        <div class='row'>
            <div class='col-md-12'>
                <h6 class='mt-4 mb-4'></h6>
   <h6 class='mt-4 mb-4'>Facebook Summary</h6>
                <table class='review-table table table-striped'>
                <thead>
                    <tr>
                      <thead>
                        <th scope='col'>Rating</th>
                        <th scope='col'>Reviews</th>
                        <th scope='col'>Cancel</th>
                    </thead>
                    </thead>
                    <tbody>
                        <tr id='fb_review_row'>
                        <td>
                            <div 
                            class='table-data'>
                                ".$fb_load_data["totals"]->average_rating."<strong>
                           </div>
                        </td>
                        <td class='table-data'>
                 ".$fb_load_data["totals"]->review_count."
                        </td>
                        <td><a  href='#' data-toggle='modal' data-target='#delfbrev'><i class='fa fa-trash red'></i> </a></td>
            </tr>
        </tbody>
    </table>

        </div>
        </div>

        <div class='row'>
        <div class='col-md-12'>
        <h6 class='mt-4 mb-4'>Filter</h6>
        </div>
        </div>
        <div class='row' id='myDIV'>
        <div class='col-md-4'>
        <button type='submit' class='btn btn-filter all active'>All</button>
        </div>
        <div class='col-md-4'>
        <button type='submit' class='btn btn-filter five'>5 Stars Only</button>
        </div>
        <div class='col-md-4'>
        <button type='submit' class='btn btn-filter fourfive'>4 and 5 Stars</button>
        </div>
        </div>
        <br><br>
        <div class='row'>
        <div class='col-md-12'>
        <button type='submit' id='save_filter' style='float:center;width:70%;' class='btn btn-success'>Save Filter</button>
        </div>
        </div>
        </div>
        <div class='modal fade' id='delfbrev' role='dialog'>
        <div class='modal-dialog'>

        <!-- Modal content-->
        <div class='modal-content'>
            <div class='modal-body'>
                <p class='text-center'> Are you sure?</p>
            </div>
            <div class='modal-footer'>
            <button type='button' class='btn btn-danger'  id='fb_rev_del_confirm'>Confirm</button>
        </div>
    </div>

    </div>");
    }
    else
    return response("Error");
}
public function load_google_rev(Request $request)
{
    $reviews = [];
    if(isset($request->listing_id))
    {
    
    }
    else
    {
    $user = Auth::user();
    $listing=Listing::where('user_id',$user->id)->with('user')->get();
    }
    $place_id=$request->place_id;
    $api_key= env("FACEBOOK_API_KEY");
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://wextractor.com/api/v1/reviews?id=".$request->place_id."&auth_token=".$api_key."&offset=0",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30000,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "accept: */*",
            "accept-language: en-US,en;q=0.8",
            "content-type: application/json",
        ),
    ));
    $response = curl_exec($curl);
    $res=json_decode($response);
    curl_close($curl);
    if(isset($res->reviews))
    {
        $reviews=array_merge($reviews,$res->reviews);
        $remaining=$res->totals->review_count-sizeof($res->reviews);
            Session()->put('google_load_data', ['remaining_reviews'=>$remaining, 'listing_id' => $listing[0]["id"],'google_acc_rating' => $res->totals->average_rating, 'user_id' => $listing[0]["user_id"],'place_id' => $place_id, 'result' => $reviews]);
           return response("Loaded");
    } else {
        return response("Error");
    }

}

public function google_connect()
{
    $google_load_data=Session()->get('google_load_data');
    if(isset($google_load_data))
    {
    $place_id=$google_load_data["place_id"];
    $api_key= env("FACEBOOK_API_KEY");
    $offset=10;
    $remaining=$google_load_data["remaining_reviews"];
    $reviews = $google_load_data["result"];
    while($remaining>0)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://wextractor.com/api/v1/reviews?id=".$place_id."&auth_token=".$api_key."&offset=".$offset."",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "accept: */*",
                "accept-language: en-US,en;q=0.8",
                "content-type: application/json",
            ),
        ));
        $response = curl_exec($curl);
        $res2=json_decode($response);
        $reviews=array_merge($reviews,$res2->reviews);
        curl_close($curl);
        $offset+=10;
        $remaining-=sizeof($res2->reviews);
    }
    foreach($reviews as $review){
        $listing_review = [
            'user_id' => $google_load_data["user_id"],
            'user_name' => $review->reviewer,
            'listing_id' => $google_load_data["listing_id"],
            'message' => $review->text,
            'rating' => $review->rating,
            'brand' => 'G API'
        ];
        $listing=[
          'place_id' => $google_load_data["place_id"],
          'avg_google_rating' => $google_load_data["google_acc_rating"],
        ];
        ListingReview::updateOrCreate($listing_review);
        Listing::where('id',$google_load_data["listing_id"])->update($listing);
    }
    $listing=Listing::where('id',$google_load_data["listing_id"])->get();
    $listing_address=ListingAddress::where('listing_id',$listing[0]->id)->get();
    $address="".$listing_address[0]->name." ".$listing_address[0]->street." ".$listing_address[0]->city."";
        return response("<div class='review_display text-center'>
        <div class='row'>
            <div class='col-md-12'>
                <h6 class='mt-4 mb-4'>Google Summary</h6>

                <table class='review-table table table-striped'>
                <thead>
                    <tr>
                        <th scope='col'>Rating</th>
                        <th scope='col'>Reviews</th>
                        <th scope='col'>Cancel</th>
                        </tr>
                    </thead>
                    <tbody >
                        <tr id='google_review_row'>
                        <td>
                            <div class='table-data'>
                               ".$google_load_data["google_acc_rating"]."
                            </div>
                        </td>
                       
                        <td><strong>".sizeof($reviews)."</strong></td>
                        
                        <td><a  href='#' data-toggle='modal' data-target='#delgooglerev'><i class='fa fa-trash red'></i> </a></td>
             
         
        </tbody>
    </table>

        </div>
        </div>

        <div class='row'>
        <div class='col-md-12'>
        <h6 class='mt-4 mb-4'>Which reviews would you like to show?</h6>
        </div>
        </div>
        <div class='row' id='myDIV'>
        <div class='col-md-4'>
        <button type='submit' class='btn btn-filter all active'>All</button>
        </div>
        <div class='col-md-4'>
        <button type='submit' class='btn btn-filter five'>5 Stars Only</button>
        </div>
        <div class='col-md-4'>
        <button type='submit' class='btn btn-filter fourfive'>4 and 5 Stars</button>
        </div>
        </div>
        <br><br>
        <div class='row'>
        <div class='col-md-12'>
        <button type='submit' id='save_filter' style='float:center;width:50%;' class='btn btn-success'>Save Filter</button>
        </div>
        </div>
        </div>
        <div class='modal fade' id='delgooglerev' role='dialog'>
        <div class='modal-dialog'>

        <!-- Modal content-->
        <div class='modal-content'>
            <div class='modal-body'>
                <p class='text-center'> Are you sure?</p>
            </div>
            <div class='modal-footer'>
            <button type='button' class='btn btn-danger'  id='google_rev_del_confirm'>Confirm</button>
        </div>
    </div>

    </div>");
    }
    else
    return response("Error");
}

public function save_filter(Request $request)
{
    $user = Auth::user();
    $filter_val = [
        'filter_val' => $request->filter_val
    ];
    if($request->filter_val=="All")
    {
        Listing::where('user_id',$user->id)->update($filter_val);
    }
    else if($request->filter_val=="Five")
    {
        Listing::where('user_id',$user->id)->update($filter_val);
    }
    else if($request->filter_val=="Four&Five")
    {
        Listing::where('user_id',$user->id)->update($filter_val);
    }
    return response("Filter Stored Successfully");
}

public function delete_reviews(Request $request)
{
    $user = Auth::user();
    ListingReview::where("user_id",$user->id)->where("brand",$request->brand)->delete();
    return response("".$request->brand." Brand Reviews Deleted Successfully");
}

public function get_google_reviews()
{
        $listings=Listing::all();
        $api_key= env("FACEBOOK_API_KEY");
        foreach($listings as $listing)
        {
            $reviews = [];
            $place_id=($listing["place_id"]!=NULL)?$listing["place_id"]:'not found';
            if($place_id != "not found"){
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://wextractor.com/api/v1/reviews?id=".$place_id."&auth_token=".$api_key."&offset=0",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30000,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => array(
                        "accept: */*",
                        "accept-language: en-US,en;q=0.8",
                        "content-type: application/json",
                    ),
                ));
                $response = curl_exec($curl);
                $res=json_decode($response);
                curl_close($curl);
                if(isset($res->reviews))
                {
                    $remaining=$res->totals->review_count-sizeof($res->reviews);
                    $reviews=array_merge($reviews,$res->reviews);
                    $offset=10;
                    while($remaining>0)
                    {
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => "https://wextractor.com/api/v1/reviews?id=".$place_id."&auth_token=".$api_key."&offset=".$offset."",
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => "",
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 30000,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => "GET",
                            CURLOPT_HTTPHEADER => array(
                                "accept: */*",
                                "accept-language: en-US,en;q=0.8",
                                "content-type: application/json",
                            ),
                        ));
                        $response = curl_exec($curl);
                        $res2=json_decode($response);
                        if (isset($res2->reviews)) {
                            $reviews=array_merge($reviews,$res2->reviews);   
                        }
                        curl_close($curl);
                        $offset+=10;
                        if (isset($res2->reviews)) {
                            $remaining-=sizeof($res2->reviews);   
                        } else {
                            $remaining = 0;
                        }
                    }
                    foreach($reviews as $review)
                    {
                            $listing_review = [
                                'updated_at' => Carbon::now(),
                                'created_at' => Carbon::now(),
                                'user_id' => $listing->user_id,
                                'user_name' => $review->reviewer,
                                'listing_id' => $listing->id,
                                'message' => $review->text,
                                'rating' => $review->rating,
                                'brand' => 'G API'
                            ];
                           ListingReview::where("listing_id",$listing->id)->where('user_name',$review->reviewer)->delete();
                           ListingReview::insert($listing_review);
                    }

                }
            }
        }
        return response("Reviews Added Successfully");
}
    public function table(SearchBusinessRequest $request)
    {
        $bizID = $request->b;
        $keyword = $request->s;
        $radius = $request->r;

        $siteService = new \App\Services\Site();

        list($latitude, $longtitude) = explode(',', AppHelper::getLatLong());
        $query = Listing::has('user')->with(['address', 'amentities'])->published()->where('business_id', $bizID);

        $queryAdsListing = Listing::has('user')->with(['address', 'amentities'])->published()->where('business_id', $bizID);

        $query->select([
            '*',
            DB::raw(
                "(select (
                    ACOS(
                        SIN(RADIANS(la.`latitude`)) * SIN(RADIANS({$latitude})) +
                        COS(RADIANS(la.`latitude`)) * COS(RADIANS({$latitude})) *
                        COS(RADIANS(la.`longitude`) - RADIANS({$longtitude}))) * 3959
                    ) from listing_addresses la WHERE la.listing_id=listings.id
                ) as distance"
            )
        ]);

        $queryAds = LocationBoostCity::whereRaw('subscription_id in (select id from subscriptions where stripe_status="active" and name="business_location_boost")');

        $boundsMi = $siteService->getCoordinatesWithinRadius($latitude, $longtitude, $radius, 'mi');
        $queryAds->where('latitude', '>', $boundsMi['min']['lat'])
                ->where('latitude', '<', $boundsMi['max']['lat'])
                ->where('longitude', '>', $boundsMi['min']['lng'])
                ->where('longitude', '<', $boundsMi['max']['lng']);


        if( !empty($_GET['dev']) ) {
            echo $queryAdsListing->toSql();
            dd('');
            dd($queryAds->pluck('user_id'));
        }
        $queryAdsListing = $queryAdsListing->whereIn('user_id', $queryAds->pluck('user_id'));


        $query->where(function ($q) use ($keyword, $radius) {
            $q->where('name', 'LIKE', "%{$keyword}%")->orWhereHas('address', function ($q2) use ($keyword, $radius) {
                $q2->filterByRequest($keyword, $radius);
            });
        });

        if ($request->c) {
            $query->whereIn('category_id', $request->c);
        }

        $data['allListings'] = $query->orderBy('distance')->get();

        $data['queryAdsListing'] = $queryAdsListing->get();
        $data['listings'] = $query->orderBy('distance')->paginate();
        $data['categories'] = Category::where('business_id', $bizID)->orderBy('name')->get()->pluck("name", "id")->toArray();

        if ($request->ajax()) {
            $view = view('mainTable.search_listing', $data)->render();
            return response()->json(['html' => $view]);
        }
        return view('mainTable.search', $data);
    }

    public function business(Business $business)
    {
        $listings = Listing::where('business_id', $business->id)->paginate();
        return view('mainTable.business', compact('listings', 'business'));
    }

    public function listing(Request $request, $slug)
    {
        $view = AppHelper::isMobile() ? 'mobile' : '';
        $data['listing'] = Listing::has('user')->with('business')->whereSlug($slug)->first();
        if (!$data['listing']) {
            return abort(404);
        }
        $reviews = ListingReview::where('listing_id', $data['listing']->id)->paginate(5);
        $data['reviews'] = $reviews;
        return view("mainTable.listing{$view}", $data);
    }

    public function getContactForm(Request $request)
    {
        return view('mainTable.contact');
    }

    public function sendEmail(ContactRequest $request)
    {
        try {
            $name = $request->name;
            $email = $request->email;
            $subject = $request->subject;
            $message = $request->message;
            Mail::to(env('CONTACT_NOTIFICATION'))->send(new Notification($name, $email, $subject, $message));
        } catch (\Exception $e) {
        }
        return redirect()->back()->with('success', 'Message sent successfully!');
    }

    public function getCMSPage(Request $request, $slug)
    {
        $record = Setting::select('value')->where('name', strtoupper($slug))->first();
        if (!$record) {
            return app()->abort(404);
        }
        return view('mainTable.cmsview', compact('record'));
    }

    public function accountEdit(Request $request)
    {
        $user = Auth::user();
        $type = 'personal';
        if (!$user->avatar) {
            $listing = Listing::where('user_id', $user->id)->first();
            $user->avatar = @$listing->profile_image;
            $type = 'business';
        }
        return view("mainTable.account_edit", compact('user', 'type'));
    }

    public function accountPayments(Request $request)
    {
        $user = auth()->user();
        $paymentMethods = collect();
        $paymentMethods = collect();
        $defaultPaymentMethod = null;

        try {
            $paymentMethods = $user->paymentMethods(['type' => 'card']);
            $defaultPaymentMethod = $user->defaultPaymentMethod();
        } catch (\Exception $e) {
            alert()->error($e->getMessage());
        }

        return view("mainTable.payments", compact('user', 'paymentMethods', 'defaultPaymentMethod'));
    }

    public function accountCharges(Request $request)
    {
        $user = auth()->user();
        $res = [];
        try {
            $charges = $user->charges();
            $invoices = $user->invoices(true);

            foreach ($charges as $charge) {
                $res[] = [
                    'date' => Carbon::createFromTimestamp($charge->created)->format('M j, Y'),
                    'invoiceUrl' => $charge->receipt_url
                ];
            }

            foreach ($invoices as $invoice) {
                $res[] = [
                    'date' => Carbon::createFromTimestamp($invoice->created)->format('M j, Y'),
                    'invoiceUrl' => $invoice->invoice_pdf
                ];
            }

            if ($res) {
                $res = Arr::sort($res, function ($v) {
                    return Carbon::createFromFormat('M j, Y', $v['date'])->timestamp;
                });
            }
        } catch (\Exception $e) {
            alert()->error($e->getMessage());
        }

        return response()->json($res);
    }

    public function saveCard(Request $request)
    {
        try {
            $user = auth()->user();
            $user->addPaymentMethod($request->paymentMethod);

            alert()->success('Successfully update new card.');
        } catch (\Exception $e) {
            alert()->error($e->getMessage());
        }

        return redirect()->back();
    }

    public function removeCard($paymentMethodId)
    {
        try {
            $user = auth()->user();
            $paymentMethod = $user->findPaymentMethod($paymentMethodId);
            $paymentMethod->delete();

            alert()->success('Card deleted successfully.');
        } catch (\Exception $e) {
            alert()->error($e->getMessage());
        }

        return redirect()->back();
    }

    public function defaultCard($paymentMethodId)
    {
        try {
            $user = auth()->user();
            $user->updateDefaultPaymentMethod($paymentMethodId);

            alert()->success('Card updated successfully.');
        } catch (\Exception $e) {
            alert()->error($e->getMessage());
        }

        return redirect()->back();
    }

    public function storeReview(ReviewRequest $request, $slug)
    {
        $data['listing'] = Listing::with('business')->whereSlug($slug)->first();
        $reviewData = [
            'user_id' => Auth::user()->id,
            'listing_id' => $data['listing']->id,
            'message' => htmlentities($request->message),
            'rating' => $request->rating,
            'brand' => $request->brand == null ? 'D' : $request->brand
        ];

        if (!$request->review_reply) {  // Edit review
            ListingReview::updateOrCreate(['id' => $request->review_id], $reviewData);
        } else {
            $reviewData['review_id'] = $request->review_id;
            ListingReview::create($reviewData);
        }

        $view = AppHelper::isMobile() ? 'mobile' : '';
        //$view = 'mobile';
        $view = view("mainTable.partials.listing.{$view}._review_listings", $data)->render();
        return response()->json(['html' => $view]);
    }

    public function getUsers(Request $request)
    {
        $user_data = [];
        $query = User::query()->active()->where('role_id', User::ROLE_BUSINESS_USER);
        if ($search = $request->get('query')) {
            $query->where('name', 'LIKE', "{$search}%");
        }
        $users = $query->get();

        foreach ($users as $key => $user) {
            $listing = $user->listing;

            $user_data[$key]['id'] = $user->id;
            $user_data[$key]['name'] = $user->name;
            $user_data[$key]['type'] = 'user';
            $user_data[$key]['href'] = $listing ? route('listing.view', $listing->slug) : 'javascript:void(0);';
            $user_data[$key]['avatar'] = $user->profile_image ?: asset('gymselect/images/user-icon.png');
        }

        return $user_data;
    }

    public function showMailNotifications()
    {
        return view("emails.reviewnotification");
    }

    public function autoSearch(Request $request)
    {
        $query = trim($request->get('q', ''), "@");
        $listings = Listing::published()->where('name', 'LIKE', "%{$query}%")->get();
        if ($listings->count()) {
            foreach ($listings as $listing) {
                $row = [];
                $valColumn = $request->get('val', 'id');
                $row['value'] = $listing->{$valColumn};
                $row['text'] = $listing->name;
                if ($request->has('icon')) {
                    $thumb = $listing->getThumbUrl('profile_image');
                    if (!$thumb) {
                        $thumb = url('/gymselect/images/user-img.jpg');
                    }
                    $row['html'] = ["<img src='{$thumb}' width='36' class='rounded-circle' />", " ", $listing->name];
                }
                $data[] = $row;
            }
            return $data;
        }

        return ['value' => 'No Result Found', 'id' => ''];
    }

    public function getMap(Request $request)
    {
        if (count($request->all()) == 1) {
            $location = array_keys($request->all());
            $locationExplode = explode(",", $location[0]);
            $request->lat = str_replace("_", ".", $locationExplode[0]);
            $request->long = str_replace("_", ".", $locationExplode[1]);
        }

        $map = "<iframe  width='100%' frameborder='0' style='border:0'
         src='https://www.google.com/maps/embed/v1/place?key=" . env('GOOGLE_MAPS_GEOCODING_API_KEY') . "&q=" . $request->lat . "," . $request->long . "' allowfullscreen>
         </iframe><div class='row'> <span class='popover-close close btn btn1'>Close</span> </div>";
        return $map;
    }

    public function editReview(Request $request)
    {

        if ($request->review_id) {
            $reviews = ListingReview::find($request->review_id)->toArray();
            return $reviews;
        }
    }

    public function showPayments()
    {
        $invoice_listings = Invoice::whereHas('subscription', function ($q) {
            $q->where('user_id', auth()->user()->id);
        })->get();
        return view("mainTable.payment", compact('invoice_listings'));
    }

    public function getUpdateForm()
    {
        $user = Auth::user();
        return view("mainTable.update_form", compact('user'));
    }

    public function updateUserProfile(AccountRequest $request)
    {
        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $request = $this->saveFiles($request);

        if ($request->type == 'personal') { // personal user
            if ($request->avatar) {
                $user->avatar = $request->avatar;
            }
        } else {  // Business user
            $listing = Listing::where('user_id', $user->id)->first();
            if ($request->avatar && $listing) {
                Listing::where("user_id", $user->id)->update(['profile_image' => $request->avatar]);
            } else {
                $user->avatar = $request->avatar;
            }
        }
        $user->save();
        return redirect()->back()->with('success', 'Profile Updated successfully!');
    }

    public function readNotification($id)
    {
        $notification = NotificationModel::find($id);
        $notification->mark_as_read = 1;
        $notification->save();
        $review = $notification->related_model();
        if (!@$review->listing) {
            $notification->delete();
            alert()->error('Review/Listing was deleted!');
            return redirect()->back();
        }
        return redirect()->to(route('listing.view', [$review->listing->slug]) . '#review-li-' . $review->id);
    }

    public function reportAbuse(ReportAbuseRequest $request)
    {
        $data = $request->except('_token');
        $data['table_class'] = ListingReview::class;
        $model = ReportAbuse::create($data);
        Mail::to(env('REPORT_NOTIFICATION'))->send(new ReportAbuseNotification($data['message'], $model->review));
    }

    public function validateBusinessCoupon(Request $request)
    {
        $coupon = collect();

        $this->validate($request, [
            'business_id' => 'required',
            'code' => [
                'required',
                function ($attribute, $value, $fail) use ($request, &$coupon) {
                    $coupon = Coupon::getCouponByCode($value, $request->business_id, $request->amount, $request->period);
                    if (!$coupon) {
                        $fail('This ' . $attribute . ' is invalid');
                    }
                }
            ]
        ]);

        return response()->json([
            'code' => $coupon->code,
            'amount' => number_format((float)$coupon->calculateAmount($request->amount), 2, '.', ''),
            'period' => $coupon->noOfPayments(),
            'offer' => $coupon->offerValue(),
            'offer_price' => number_format((float)$request->amount - $coupon->calculateAmount($request->amount), 2, '.', ''),

        ]);
    }

    public function validateVerificationCoupon(Request $request)
    {
        $coupon = collect();
        $this->validate($request, [
            'code' => [
                'required',
                function ($attribute, $value, $fail) use ($request, &$coupon) {
                    $type = \Auth::user()->business_id;
                    $coupon = Coupon::where('code', $value)->where('coupon_type', 'V')->whereHas('business', function ($query) use ($type) {
                        $query->where('businesses.id', $type);
                    })->first();

                    if (!$coupon) {
                        $fail('This ' . $attribute . ' is invalid');
                    }
                }
            ]
        ]);

        return response()->json([
            'code' => $coupon->code,
            'amount' => number_format((float)$coupon->calculateAmount($request->amount), 2, '.', ''),
            'offer_price' => number_format((float)($request->amount - $coupon->calculateAmount($request->amount)), 2, '.', ''),
        ]);
    }

    protected function showNotifications()
    {
        $notifications = NotificationModel::where('receiver_id', auth()->user()->id)->orderBy('mark_as_read', 'ASC')->get();
        return view("mainTable.notification", compact('notifications'));
    }

    public function businessStatus($id, $status)
    {
        if (in_array($status, [0, 1])) {
            $listing = Listing::findOrFail($id);
            $listing->update(['published' => $status]);
        }

        return redirect()->back();
    }

    public function businessBoost()
    {
        $listing = Auth::user()->listing;
        $setting = Setting::select('value')->where('name', 'ORGANIZATION')->first();
        $boost_count= Boost::where('listing_id',$listing->id)->count();
        return view("mainTable.business_boost_form", compact('listing', 'setting','boost_count'));
    }

    public function businessLocationBoost()
    {
        $setting = Setting::select('value')->where('name', 'ORGANIZATION')->first();
        $subscriptionPlans = LocationBoostPlan::where(['status' => 'active'])->get();
        $activeSubscriptions = Subscription::where(['user_id' => auth()->user()->id,'stripe_status'=>'active','name'=>'business_location_boost'])->get();
        if($activeSubscriptions->count() <= 0) {
            return view("mainTable.business_location_boost_form", compact('subscriptionPlans', 'setting'));
        }
        return redirect()->route('business.businesslocationboostcity');
    }

    public function doBusinessLocationBoost(Request $request)
    {
        $user = auth()->user();
        $existingPlan = LocationBoostPlan::where(['stripe_plan_id' => $request->input('stripePlanId')])->first();

        if(!$existingPlan) {
            return response()->json(['message' => 'Invalid plan'], 422);
        }

        try {
            $user->createOrGetStripeCustomer([
                'name' => $user->name,
                'address' => [
                    'line1' => $user->address_line_1,
                    'line2' => $user->address_line_2,
                    'city' => $user->city,
                    'postal_code' => $user->postal_code,
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        //Subscription
        $subscriptionBuilder = $user->newSubscription('business_location_boost', $request->input('stripePlanId'));

        try {
            $newSub = $subscriptionBuilder->create($request->input('paymentMethod'));
            for($i=0; $i<$existingPlan->allowed_cities; $i++) {
                LocationBoostCity::create([
                    'user_id' => auth()->user()->id,
                    'subscription_id' => $newSub->id
                ]);
            }
            $returnUrl = route('business.businesslocationboostcity');
            return response()->json(['message' => 'Location boost purchased successfully!', 'returnUrl' => $returnUrl], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    public function saveLocations(Request $request)
    {
        if($request->has('data') && is_array($request->input('data'))) {
            foreach($request->input('data') as $val){
                $res = LocationBoostCity::find($val['id']);
                if($res) {
                    $res->city = $val['city'];
                    $res->country = $val['country'];
                    $res->latitude = $val['latitude'];
                    $res->longitude = $val['longitude'];
                    $res->save();
                }
            }
        }
        $returnUrl = route('home');
        return response()->json(['message' => 'Location boost cities added successfully!', 'returnUrl' => $returnUrl], 200);
    }

    public function businessLocationBoostCity()
    {
        $setting = Setting::select('value')->where('name', 'ORGANIZATION')->first();
        $subscriptionPlans = LocationBoostPlan::where(['status' => 'active'])->get();

        $activeSubscriptions = Subscription::where(['user_id' => auth()->user()->id,'stripe_status'=>'active','name'=>'business_location_boost'])->get();

        $locationBoostCities = LocationBoostCity::whereIn('subscription_id', $activeSubscriptions->pluck('id'))->get();

        $listing = Listing::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->first();

        $countries = ["England","Scotland","Northern Ireland","Wales"];
        $cities = json_decode(file_get_contents(storage_path() . "/cities.json"), true);

        return view("mainTable.business_location_boost_cities", compact('subscriptionPlans', 'setting', 'countries','cities','locationBoostCities','listing'));
    }
    
    public function businessLocationBoostCityFast()
    {
        // $usrt = User::where('id', 739)->first();
        // $st = Auth::user()->impersonate($usrt);
        // dd($st);
        $setting = Setting::select('value')->where('name', 'ORGANIZATION')->first();
        $subscriptionPlans = LocationBoostPlan::where(['status' => 'active'])->get();

        $activeSubscriptions = Subscription::where(['user_id' => auth()->user()->id,'stripe_status'=>'active','name'=>'business_location_boost'])->get();

        $locationBoostCities = LocationBoostCity::whereIn('subscription_id', $activeSubscriptions->pluck('id'))->get();

        $listing = Listing::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->first();

        $countries = ["England","Scotland","Northern Ireland","Wales"];
        $cities = [];
        $simpleCities = [];
        
        foreach($countries as $_country){
            $towns = Towns::where('subCountry', $_country)->get()->toArray();
            foreach($towns as $_town){
                $simpleCities[$_country][] = $_town['name'];
                $cities[$_country] = ['latitude' => $_town['lat'], 'longitude' => $_town['lng'], 'city' => $_town['name']];
            }
        }
        
        // dd($simpleCities);

        return view('mainTable.business_location_boost_cities_fast', compact('subscriptionPlans', 'setting', 'simpleCities', 'countries','cities','locationBoostCities','listing'));
    }

    public function getCity(Request $request)
    {
        // $cities = json_decode(file_get_contents(storage_path() . "/cities.json"), true);
        $towns = Towns::where('country', 'GB')->where('subCountry', $request['country'])->get()->toArray();
        $cities = [];
        foreach($towns as $_town){
            $cities[] = $_town['name'];    
        }
        $data['country'] = $request['country'];
        $data['cities'] = $cities;
        return response()->json($data);
    }

    public function businessBoosted(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $listing = Listing::findOrFail($id);

            $boost = new Boost();
            try {
                $setting = Setting::select('value')->where('name', 'ORGANIZATION')->first();
                $value = $setting->value;
                $price = @$value['BOOST_OFFER_PRICE'] ? $value['BOOST_OFFER_PRICE'] : $value['VERIFICATION_PRICE'];
                $user = $listing->user;

                $paymentId = NULL;
                if ($price > 0) {
                    try {
                        $user->addPaymentMethod($request->paymentMethod);
                        $payment = $user->charge((int)($price * 100), $request->paymentMethod, [
                            'description' => "{$listing->name} payment for review boost"
                        ]);
                    } catch (\Exception $e) {
                        alert()->error("Payment Error: {$e->getMessage()}");

                        return back();
                    }
                    $paymentId = $payment->id;
                }

                $boost->user_id = $user->id;
                $boost->payment_id = $paymentId;
            } catch (\Exception $e) {
                return back()->with('error', 'Please try again later');
            }
            $boost->listing_id = $id;
            $boost->brand = $request->brand ?: [];
            $boost->message = $request->message;
            $boost->status = Boost::PENDING;
            $boost->save();

            event(new RequestBoost($boost));
            return back()->with('success', 'Review Boost submitted successfully');
        }
    }

    public function businessVerify()
    {
        $listing = Auth::user()->listing;
        $setting = Setting::select('value')->where('name', 'ORGANIZATION')->first();
        if ($listing->business_id == 1) {
            $field = 'GYM_VERIFICATION_COUPON';
        } elseif ($listing->business_id == 2) {
            $field = 'COACH_VERIFICATION_COUPON';
        } elseif ($listing->business_id == 3) {
            $field = 'PHYSIO_VERIFICATION_COUPON';
        }
        $enableCoupon = (bool)Setting::getSetting($field);

        return view("mainTable.business_verify_form", compact('listing', 'setting', 'enableCoupon'));
    }

    public function businessVerifyUpload(Request $request)
    {
        $request = $this->saveFiles($request);
        return response()->json($request->file);
    }

    public function businessVerification(Request $request, $id)
    {
        $this->validate($request, [
            'verification_file' => 'required'
        ]);

        //Coupon
        $coupon = null;
        if ($code = $request->coupon_code) {
            $coupon = Coupon::where('code', $code)->where('coupon_type', 'V')->whereHas('business', function ($query) {
                $query->where('businesses.id', \Auth::user()->business_id);
            })->first();

            if (!$coupon) {
                alert()->error('This coupon is invalid');
                return redirect()->route('business.verify');
            }
        }

        if ($request->isMethod('post')) {
            $listing = Listing::findOrFail($id);
            $verification = new Verification();
            try {
                $setting = Setting::select('value')->where('name', 'ORGANIZATION')->first();
                $value = $setting->value;
                $price = @$value['VERIFICATION_OFFER_PRICE'] ? $value['VERIFICATION_OFFER_PRICE'] : $value['VERIFICATION_PRICE'];
                if ($coupon) {
                    $price = $coupon->calculateAmount($price);
                }
                $user = $listing->user;

                $paymentId = NULL;
                if ($price > 0) {
                    try {
                        $user->addPaymentMethod($request->paymentMethod);
                        $payment = $user->charge((int)($price * 100), $request->paymentMethod, [
                            'description' => "{$listing->name} payment for verification"
                        ]);
                    } catch (\Exception $e) {
                        alert()->error("Payment Error: {$e->getMessage()}");

                        return back();
                    }
                    $paymentId = $payment->id;
                }

                $verification->user_id = $user->id;
                $verification->payment_id = $paymentId;
                if ($coupon) {
                    $verification->coupon_id = $coupon->id;
                    $coupon->increment('redemptions');
                }
            } catch (\Exception $e) {
                return back()->with('error', 'Please try again later');
            }
            $request = $this->saveFiles($request);
            $verification->listing_id = $id;
            $verification->status = Verification::PENDING;
            $verification->save();

            foreach ($request->verification_file as $filepath) {
                FileVerification::create(['verification_id' => $verification->id, 'file_path' => $filepath]);
            }

            event(new RequestVerification($verification));
            return back()->with('success', 'Your files has been successfully Uploaded');
        }
    }

    public function verifyToken($token)
    {
        $user = User::query()->where('verify_token', $token)->first();
        if ($user) {
            $user->update(['status' => 1]);
            auth()->login($user);
            alert()->success('User activated successfully!');
            return redirect()->route('home');
        } else {
            alert()->error('Verification Token invalid');
            return redirect()->route('home');
        }
    }

    public function partners()
    {
        $partners = Partner::query()->get();

        return view('mainTable.partners', compact('partners'));
    }


    public function searchGym(Request $request)
    {
        $query = $request->term;

        $data = array();

        if ($query) {
            $listings = Listing::published()->has('user')->whereNotNull('name')->where('name', 'LIKE', $query . '%')->get();

            foreach ($listings as $listing) {
                $data[] = array('name' => $listing->name, 'slug' => route('listing.view', $listing->slug), 'category' => $listing->category->name, 'image' => $listing->getThumbUrl('profile_image'));
            }
        }

        return response()->json($data);
    }

    public function aboutUs()
    {
        $faqs = Faq::active()->get();

        return view('mainTable.about_us', compact('faqs'));
    }

    public function testEmail($bid = 1)
    {
        // UserRegistered
        $user = User::latest()->first();
        event(new UserRegistered($user));

        // ListingCreated Gym
        $listing = Listing::query()->where('business_id', 1)->latest()->first();
        if ($listing) {
            event(new ListingCreated($listing));
        }

        // ListingCreated Coach
        $listing = Listing::query()->where('business_id', 2)->latest()->first();
        if ($listing) {
            event(new ListingCreated($listing));
        }

        // ListingCreated Physio
        $listing = Listing::query()->where('business_id', 3)->latest()->first();
        if ($listing) {
            event(new ListingCreated($listing));
        }
    }

    public function dropzoneUpload(Request $request)
    {
        return $this->dropzoneSave($request);
    }

    public function legalPage()
    {
        return view('mainTable.legals');
    }
}
