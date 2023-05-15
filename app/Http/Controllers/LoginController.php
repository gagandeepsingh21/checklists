<?php

namespace App\Http\Controllers\Auth;

use DB;
use Session;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller implements Authenticatable{
    /*
      |--------------------------------------------------------------------------
      | Login Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles authenticating users for the application and
      | redirecting them to your home screen. The controller uses a trait
      | to conveniently provide its functionality to your applications.
      |
     */

use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = '/home';
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $username;

    /**
     * Create a new controller instance.
     */
    public function __construct() {
        $this->middleware('guest')->except(['logout']);
        $this->username = $this->findUsername();
    }

    public function getAuthIdentifierName(){}
    public function getAuthIdentifier(){}
    public function getAuthPassword(){}
    public function getRememberToken(){}
    public function setRememberToken($value){}
    public function getRememberTokenName(){}

    public function login(Request $request){
        dd($request);

        $user = null;
        $username = $request->input('username');
        $password = $request->input('password');

        $credentials['username'] = null;
        $credentials['password'] = null;

        if(is_null($username)){
            $credentials['username'] = ['The Username field is Mandatory!'];
        }

        if(is_null($password)){
            $credentials['password'] = ['The Password field is Mandatory!'];
        }

        if($credentials['username'] || $credentials['password']){
            return Redirect::back()->withErrors($credentials);
        }

        // // // Go to ldap
        $ldap_host = env("LDAP_HOST");
        $ldap_domain = env("STRATHMORE_DOMAIN");
        $ldap_std_domain = env("STUDENTS_DOMAIN");

        if (is_numeric($username)) {
            $ldap_domain = $ldap_std_domain;
        }

        $ad = ldap_connect("ldap://{$ldap_host}") or die('Could not connect to LDAP server.');

        $bind = null;
        if($ad){
            ldap_set_option($ad, LDAP_OPT_PROTOCOL_VERSION, 2);
            ldap_set_option($ad, LDAP_OPT_REFERRALS, 1);
            $bind = @ldap_bind($ad, "{$username}@{$ldap_domain}", $password);
        }

        if ($bind) {
            $user_exists = User::where("username", $username)->count();

            if($user_exists == 0){
                $user_details = $this->getLDAPUser($username);

                $name = $user_details[0]["sn"];
                $first_name = $user_details[0]["givenname"];
                $email = $user_details[0]["mail"];
                $account_type = $user_details[0]["account_type"];

                $surname = $name;
                $middle_name = null;

                $names = explode(" ", $name);
                if(count($names) > 1){
                    $surname = $names[count($names) - 1];
                    $middle_name = $names[0];

                    for($i = 1; $i < (count($names) - 1); $i++){
                        $middle_name .= " " . $names[$i];
                    }
                }


                $user = User::updateOrCreate(['username' => $username], ['surname' => $surname, 'first_name' => $first_name , 'middle_name' =>  $middle_name, 'username' => $username, 'email' => $email]
                        );
            }
            else{
                $user = User::where("username", $username)->first();
            }
        }
        else{
            return Redirect::back()->withErrors(['username' => ['Invalid Credentials!'], 'password' => ['Invalid Credentials!']]);
        }
        

        if($user){
            Auth::login($user);
        }
        return $this->sendLoginResponse($request);
    }

    public function getLDAPUser($username) {

        $ldap_host = env("LDAP_HOST");
        $ldap_port = env("LDAP_HOST_PORT","3268");
        $ldap_domain = env("STRATHMORE_DOMAIN");

        // LDAP user with search permissions
        $ldapuser = env("LDAP_HOST_USER"); 
        $ldappass = env("LDAP_HOST_PASSWORD");

        \Log::info("====Start Get User====");

        $user_details = array();
        $account_type = 'staff';

        $ldaptree    = env("LDAP_STAFF_TREE", "OU=Strathmore University,DC=strathmore,DC=local");
        if(is_numeric($username)){
            $ldaptree    = env("LDAP_STUDENT_TREE", "ou=strathmore university students,dc=std,dc=strathmore,dc=local");

            $account_type = 'student';
        }
        // connect to LDAP
        $ldapconn = ldap_connect("ldap://{$ldap_host}:{$ldap_port}") or die("Could not connect to LDAP server.");

        if($ldapconn) {
            \Log::info("====Connected====");
            // binding to ldap server
            ldap_set_option( $ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3 );
            ldap_set_option( $ldapconn, LDAP_OPT_REFERRALS, 0);
            $ldapbind = ldap_bind($ldapconn, "{$ldapuser}@{$ldap_domain}", $ldappass) or die ("Error trying to bind: ".ldap_error($ldapconn));
            // verify binding
            \Log::info("====Binding...====");
            if ($ldapbind) {
                \Log::info("====Bind Okay====");
                $filter="(SAMAccountName=".$username.")";

                // What we want to return
                $justthese = array("sn", "givenname", "mail");

                $result=ldap_search($ldapconn, $ldaptree, $filter, $justthese);
                $data = ldap_get_entries($ldapconn, $result);


                $user_details[0]["account_type"] = $account_type;
                $user_details[0]["sn"] = $data["0"]["sn"]["0"];
                $user_details[0]["givenname"] = $data["0"]["givenname"]["0"];

                $user_details[0]["mail"] = null;
                if(isset($data["0"]["mail"])){
                    $user_details[0]["mail"] = $data["0"]["mail"]["0"];
                }
                
            } else {
                \Log::info("LDAP bind failed...");
            }

        }
        // all done? clean up
        ldap_close($ldapconn);
        \Log::info("====User Details====");
        // \Log::info($user_details);
        return $user_details;
    }
    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function findUsername() {
        Session::forget("my_cart");
        Session::forget('current_firm');
        $login = request()->input('username');

        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        request()->merge([$fieldType => $login]);

        return $fieldType;
    }

    /**
     * Get username property.
     *
     * @return string
     */
    public function username() {
        return $this->username;
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request) {
        $request->session()->regenerate();

        return $this->authenticated($request, $this->guard()->user())
                ? : redirect()->intended($this->redirectPath());
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user) {
        //
    }

    public function redirectPath() {
        if (method_exists($this, 'redirectTo')) {
            return $this->redirectTo();
        }

        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/';
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard() {
        return Auth::guard();
    }

}