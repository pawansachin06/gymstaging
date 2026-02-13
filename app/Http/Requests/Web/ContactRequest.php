<?php
namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;
use TimeHunter\LaravelGoogleReCaptchaV3\Validations\GoogleReCaptchaV3ValidationRule;
class ContactRequest extends FormRequest
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
        $rules['name'] = 'required';
        $rules['email'] = 'required|email';
        $rules['subject'] = 'required';
        $rules['message'] = 'required';
        $rules['g-recaptcha-response'] = 'required';
        $rules['terms_and_conditions'] = 'required';

       return $rules;
    }
}
