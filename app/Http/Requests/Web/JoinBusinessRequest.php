<?php

namespace App\Http\Requests\Web;
use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;
use TimeHunter\LaravelGoogleReCaptchaV3\Validations\GoogleReCaptchaV3ValidationRule;

class JoinBusinessRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {  
       
        // if($this->get('email')  && !$this->get('step')){
        //   $rules['email'] = 'required|email|unique:users'; 
        //   $rules['password'] = 'min:6|required_with:password_confirmation|same:password_confirmation';
        //   return $rules; 
        // }

        // if(($this->get('password_confirmation') ) && !$this->get('step')){
        //     dd("fd");
        //     $rules['password'] = 'min:6|required_with:password_confirmation|same:password_confirmation';
        //     return $rules; 
        // }


        if(auth()->guest()) {
            
            if ($this->get('step') == 0 || Request::ajax()==true) {
               
                $rules['name'] = 'required';
                $rules['email'] = 'required|email|unique:users';
                $rules['password'] = 'min:6';
                $rules['password_confirmation'] = 'min:6|required_with:password|same:password';
                $rules['terms_and_conditions'] = 'required';
                if(env('ENABLE_SIGNUP_RECAPTCHA' , 0)){
                    $rules['g-recaptcha-response'] = 'required';
                }
            }
            // if ($this->get('step') == 1) {
            //     $rules['stripe_token'] = 'required';
            // }
        } else {
            $business=Category::where('id',$this['listing']['category_id'])->get('business_id');
            if(isset($this['listing']['category_id']))
            {
            if($business[0]->business_id==2)
            {
                
                $rules['listing.name'] = 'required';
                $rules['listing.category_id'] = 'required';
                $rules['listing.timings'] = 'nullable|array';
                $rules['listing.signup_url'] = 'nullable|url';
                $rules['amenities'] = 'required|array';
                $rules['address.city'] = 'required';
            }
            else
            {
            $rules['listing.name'] = 'required';
            $rules['listing.category_id'] = 'required';
            $rules['listing.timings'] = 'nullable|array';
            $rules['listing.signup_url'] = 'nullable|url';
            $rules['amenities'] = 'required|array';
            $rules['address.name'] = 'nullable';
            $rules['address.street'] = 'nullable';
            $rules['address.city'] = 'required';
            $rules['address.country'] = 'required';
            $rules['address.postcode'] = 'nullable';
            }
        }
        else
        {
            $rules['listing.name'] = 'required';
            $rules['listing.category_id'] = 'required';
            $rules['listing.timings'] = 'nullable|array';
            $rules['listing.signup_url'] = 'nullable|url';
            $rules['amenities'] = 'required|array';
            $rules['address.name'] = 'nullable';
            $rules['address.street'] = 'nullable';
            $rules['address.city'] = 'required';
            $rules['address.country'] = 'required';
            $rules['address.postcode'] = 'nullable';
        }
    }

        return $rules;
    }

    public function attributes()
    {
        return [
            'name' => (request()->segment(3) == 'personal') ? 'Name' : 'Facility Name',
            'listing.name' => 'Name',
            'listing.category_id' => 'Category',
            'amenities'=> 'Features',
            'listing.timings' => 'Timings',
            'listing.signup_url' => 'Signup Url',
            'address.name'  => 'Address number',
            'address.street'  => 'Street',
            'address.city'  => 'City',
            'address.country'  => 'Country',
            'address.postcode'  => 'Postcode',

        ];
    }
}
