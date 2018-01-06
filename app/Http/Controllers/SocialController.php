<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\SocialUser;
use App;
use Auth;
use Redirect;
use Config;
use Socialite;


class SocialController extends Controller
{
    //

    public function getSocialRedirect($provider){
        $providerKey = Config::get('services.' . $provider);
        if(empty($providerKey)){
            return App::abort(404);
        }
        return Socialite::driver($provider)->redirect();
    }

    public function getSocialCallback($provider,Request $request){
        $socialite_user = Socialite::with($provider)->user();
        $user=User::where('email',$socialite_user->email)->where('provider',$provider)->first();
        if(!empty($user)){
            $login_user = $user; //使用之前的帳號登入
                }else{
                    //建立帳號
                    $new_user = new User([
                        'email' => $socialite_user->email,
                        'name' => $socialite_user->name,
                    ]);
                    $new_user->provider=$provider;
                    $new_user->save();
                    $new_socialUser = new SocialUser ([
                        'user_id' => $new_user->id,
                        'provider_user_id' => $socialite_user->id,
                        'provider' => $provider,
                    ]);
                    $new_socialUser->save();
                    $login_user=$new_user;
                }
                if(!is_null($login_user)){
                    Auth::login($login_user);       //設定為驗證過的登入者
                    return Redirect::action('HomeController@index');
                }
            }



}


