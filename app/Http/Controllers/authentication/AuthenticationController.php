<?php

namespace App\Http\Controllers\authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Auth;
use Mail;
use App\Mail\RegisterMail;
class AuthenticationController extends Controller
{
 public function index(){
  return view('Authentication.login');
 }
    public function loginProcc(Request $req){
            $req->validate([
                'email' => 'required',
                'password' => 'required',
                'g-recaptcha-response' => 'required'
            ]);
            $recaptcha = $_POST['g-recaptcha-response'];
                    $secret_key = '6LfWkd0mAAAAAGzO6cmejBLvPy4WMBSZUP-CUoR2';
                    $url = 'https://www.google.com/recaptcha/api/siteverify?secret='. $secret_key . '&response=' . $recaptcha;
                    $response_json = file_get_contents($url);
                    $response = (array)json_decode($response_json);
            if($response['success'] == 1){
                
            }else{
                return redirect()->back()->with(['error'=>'Google recaptcha is not valid']);
            }
            if(Auth::attempt(['email'=>$req->email,'password'=>$req->password])){
                return redirect('/admin-dashboard')->with(['success'=>'welcome to admin Dashboard']);
            }else{
                return redirect()->back()->with(['error'=>'your credentials are wrong failed to login']);
            }

    }
    public function logout(){
        Auth::logout();
        return redirect('/admin-login')->with('success',"You have logged out succesfully");
    }
    public function UserLoginProcc(Request $request){
        $request->validate([
            'useremail' => 'required', 
            'password' => 'required',
        ]);
        
        $user_identifier = $request->input('useremail');
        $credentials = [
            filter_var($user_identifier, FILTER_VALIDATE_EMAIL) ? 'email' : 'name' => $user_identifier,
            'password' => $request->input('password'),
        ];
        
        if (Auth::attempt($credentials)) {
            // Authentication passed
            return response()->json(Auth::user());
        } else {
            // Authentication failed
            return response()->json(['error' => 'Invalid credentials']);
        }
    }
    
    public function registerProcc(Request $request){
        $request->validate([
            'email' => 'required|unique:users,email',
            'confirm_email' => 'required_with:email|same:email',
            'username' => 'required|unique:users,name',
            'firstname' => 'required',
            'lastname' => 'required',
        ]);
        $user = new User;
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->name = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($request->email);
        $user->is_admin = 0;
        $user->save();
        $mailData = [
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->email,
        ];
        $mail = Mail::to($request->email)->send(new RegisterMail($mailData));
        // return response()->json($request->all());
        return response()->json('You registration has been done , please check your password on your email.');
    }

}
