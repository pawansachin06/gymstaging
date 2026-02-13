<?php
namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class JoinPersonalRequest extends FormRequest
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
        if(auth()->guest()) {
                $rules['name'] = 'required';
                $rules['email'] = 'required|email|unique:users';
                $rules['password'] = 'min:6';
                $rules['password_confirmation'] = 'min:6|required_with:password|same:password';
                if(env('ENABLE_SIGNUP_RECAPTCHA' , 0)){
                    $rules['g-recaptcha-response'] = 'required';
                }
        }
        return $rules;
    }
}
