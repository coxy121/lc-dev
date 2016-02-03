<?php
namespace App\Http\AuthTraits;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Exceptions\EmailNotProvidedException;
use App\Exceptions\EmailAlreadyInSystemException;
use App\Exceptions\AlreadySyncedException;
use Redirect;
use App\Exceptions\CredentialsDoNotMatchException;
trait ManagesSocial
{
    private function socialUserHasNo($socialUserEmail)
    {
        return $socialUserEmail == null;
    }
    /**
     * @return mixed
     */

    private function socialUserAlreadyLoggedIn()
    {
        return Auth::check();
    }
    /**
     * Return user if exists; create and return if doesn't already exist
     *
     * @param $facebookUser
     * @return User
     */

    private function findOrCreateUser($facebookUser)
    {
        // is email already in table?
        // if email is in table, does the facebook id match?
        // if there is a match, return $authUser, if not throw exception
        if( $authUser = User::where('email', $facebookUser->email)->first()){
            if( ! $authUser->facebook_id == $facebookUser->id){
                throw new EmailAlreadyInSystemException;
            }
            return $authUser;
        }

        // if $facebookUser->id already is in database
        if(User::where('facebook_id', '=', $facebookUser->id)->first()){
            throw new CredentialsDoNotMatchException;
        }

        //create user if not already exists and email does not already exist.
        $password = $this->makePassword();
        return User::create([
            'name' => $facebookUser->name,
            'email' => $facebookUser->email,
            'password' => $password,
            'status_id' => 10,
            'facebook_id' => $facebookUser->id,
            'avatar' => $facebookUser->avatar
        ]);
    }
    /**
     * @return string
     */

    private function makePassword()
    {
        $passwordParts = rand() . str_random(12);
        $password = bcrypt($passwordParts);
        return $password;
    }
    private function userSyncedOrSync($facebookUser)
    {
        //if you are logged in and userSynced is true, you are already synced
        if($this->userSynced($facebookUser)){
            throw new AlreadySyncedException;
        } else {
            // lookup user and update user record
            $id = Auth::user()->id;
            $user = User::findOrFail($id);
            $user->update(['facebook_id' => $facebookUser->id,
                'avatar' => $facebookUser->avatar]);
            alert()->success('Confirmed!', 'You are now synced...');
            return $this->redirectUser();
        }
    }
    /**
     * @param $facebookUser
     * @return mixed
     */

    private function userSynced($facebookUser)
    {
        $authUser = User::where('email', $facebookUser->email)->first();
        return ($authUser->facebook_id == $facebookUser->id) ?  true : false;
    }
    private function redirectUser()
    {
        if (Auth::user()->isAdmin()){
            return redirect()->route('admin');
        }
        return redirect()->route('home');
    }
}