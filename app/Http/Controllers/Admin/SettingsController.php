<?php

namespace App\Http\Controllers\Admin;

use App\Customfield;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Datatables;
use Auth;
use Alert;
use Hash;
use Validator;

class SettingsController extends Controller
{
    public function index(Request $request, $slug)
    {
        if(!in_array($slug, Setting::$allowFields)) {
            app()->abort(404);
        }

        $SlugName = Setting::slugToName($slug);

        if($request->isMethod('post')){
            $data = $request->value;
            $this->_modify_form_data($data, $SlugName);

            Setting::updateOrCreate(
                ['name'=> $SlugName],
                ['value' => Setting::sanitizeValue($data)]
            );
            Alert::success('Setting updated successfully!', 'Success');
            return redirect()->back()->withInput($request->input());
        }

        $data['slug'] = $slug;
        $data['modelval'] = Setting::getSetting($SlugName);
        $this->_append_form_data($data, $SlugName);

        return view('admin.settings.form', $data);
    }

    protected function _append_form_data(&$data, $slugname){
        return;
    }

    protected function _modify_form_data(&$data, $slugname){
        return;
    }

     public function showUpdateProfileForm(Request $request)
    {
        $user = Auth::getUser();
       
        return view('admin.settings.profile', compact('user'));
    }

    public function updateprofile(Request $request)
    {
        $user = Auth::getUser();
        $user->name = $request->name;
        if($request->image){
            $filename = time().".png";
            Storage::disk('public')->putFileAs('profile_picture',$request->image , $filename);
            $user->avatar = $filename;
        }
        $user->save();
        return redirect()->back()->with('success', 'Profile changed successfully!');
       
    }

    public function showChangePasswordForm()
    {
        $user = Auth::getUser();

        return view('admin.settings.change_password', compact('user'));
    }

    /**
     * Change password.
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function changePassword(Request $request)
    {
        $user = Auth::getUser();  
        
        $this->validator($request->all())->validate();
     
        if (Hash::check($request->get('current_password'), $user->password)) {
            $user->password = $request->get('new_password_confirm');
            $user->save();
            return redirect()->back()->with('success', 'Password change successfully!');
        } else {
            return redirect()->back()->withErrors('Current password is incorrect');
        }
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'current_password' => 'required',
            'new_password' => ['required'],
            'new_password_confirm' => ['same:new_password'],
        ]);
    }
}
