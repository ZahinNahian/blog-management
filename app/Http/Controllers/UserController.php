<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function UserLogin(Request $request) {
        $incomingdata = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $user=User::where('email', $request->email)->where('password', $request->password)->first();



        if ($user!==null) {
            $email=$request->email;
            $user_id=$user->id;
    
            $request->session()->put('email', $email);
            $request->session()->put('user_id', $user_id);

            $data=['status'=>true, 'message'=>'Login Successful'];
            return redirect('/feed-page')->with('flash',$data);
        } else {
            $data=['status'=>false, 'message'=>'Login Failed'];
            return redirect('/')->with('flash', $data);
        }

    } //End Method

    public function RegistrationPage() {
        return Inertia::render('RegistrationPage');
    } //End Method

    public function UserRegistration(Request $request) {
        try {
            $incomingdata = $request->validate([
                'username' => ['required', 'string'],
                'email' => ['required', 'email'],
                'password' => ['required', 'string', 'max:10'],
                'profile_pic' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            ]);
    
            if ($request->hasFile('profile_pic')) {
                $imagefile = $request->file('profile_pic');
                $extension = $imagefile->getClientOriginalExtension();
                $rename = $request->username . "'s_pp." . $extension;
                $path = 'uploads/profile_pics/';
                $imagefile->move(public_path($path), $rename);
                $incomingdata['profile_pic'] = $path . $rename;
            }
    
            User::create($incomingdata);
            $data=['status'=>true, 'message'=>"Registration Successful"];
            return redirect('/')->with('flash', $data);
        } catch (Exception $e) {
            $data=['status'=>false, 'message'=>$e->getMessage()];
            return redirect('/registration-page')->with('flash', $data);
        }
    } //End Method

    public function logout(Request $request) {
        $request->session()->forget("email");
        $request->session()->forget("id");
        $data=['status'=>true, 'message'=>'Loggedout'];
        return redirect('/')->with('flash', $data);
    }

}
