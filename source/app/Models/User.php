<?php

namespace App\Models;

use Exception, Log, DB;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\File;
use Illuminate\Notifications\Notifiable;
use Session;

class User extends Authenticatable
{
    use Notifiable;
    const STATUS_FILTER = [
        'active' => 'active',
        'locked' => 'locked'
    ];

    const ROLE_FILTER = [
        'user' => 'user',
        'admin' => 'admin'
    ];

    const LOGIN_TYPE = [
        'UNKNOWN' => 'Unknown',
        'NORMAL' => 'Password',
        'FACEBOOK' => 'Facebook',
        'GOOGLE_PLUS' => 'GooglePlus'
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id', 'full_name', 'email', 'phone', 'password', 'birth_day', 'address', 'image_1',
        'is_locked', 'fb_uid', 'google_uid', 'has_password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $reset_password_url = url(route('password.reset', $token, false));
        Log::info($reset_password_url);
//        $params = array(
//            'reset_password_url' => $reset_password_url,
//            'full_name' => $this->full_name
//        );
//        Mail::to($this)->send(new SimpleEmailSender('Khôi phục mật khẩu', 'emails.auth.reset_admin', $params, null));
    }

    public function isAdmin()
    {
        return !empty($this->role_id);
    }

    /**
     * Get the role of user.
     */
    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }

    public function roleName()
    {
        return !empty($this->role) ? __('admin.users.roles.admin') : __('admin.users.roles.user');
    }

    public function imageUrl()
    {
        if (!empty($this->image_1) && File::exists(public_path(config('constants.AVATAR_PROFILE_FOLDER')) . '/' . $this->image_1)) {
            return asset(config('constants.AVATAR_PROFILE_FOLDER') . '/' . $this->image_1);
        }

        $facebook = $this->facebookImage();
        if (!empty($facebook)) {
            return $facebook;
        }

        $googlePlus = $this->googlePlusImage();
        if (!empty($googlePlus)) {
            return $googlePlus;
        }

        return asset('common-assets/img/profile.jpg');
    }

    public function imageFullUrl()
    {
        if (!empty($this->image_1) && File::exists(public_path(config('constants.AVATAR_PROFILE_FOLDER')) . '/' . $this->image_1)) {
            return url(config('constants.AVATAR_PROFILE_FOLDER') . '/' . $this->image_1);
        }

        $facebook = $this->facebookImage();
        if (!empty($facebook)) {
            return $facebook;
        }

        $googlePlus = $this->googlePlusImage();
        if (!empty($googlePlus)) {
            return $googlePlus;
        }

        return url('common-assets/img/profile.jpg');
    }

    public function facebookImage()
    {
        if (!empty($this->fb_uid)) {
            return "http://graph.facebook.com/" . $this->fb_uid . "/picture?type=square";
        }

        return null;
    }

    public function googlePlusImage()
    {
        if (!empty($this->google_uid)) {
            try {
                $content = @file_get_contents("http://picasaweb.google.com/data/entry/api/user/" . $this->google_uid . "?alt=json");
                if (strpos($http_response_header[0], "200")) {
                    $d = json_decode($content);
                    return $d->{'entry'}->{'gphoto$thumbnail'}->{'$t'};
                }
            } catch (Exception $ex) {
            }
        }

        return null;
    }

    public function status()
    {
        if($this->is_locked){
            return __('admin.users.statuses.locked');
        }
        return __('admin.users.statuses.active');
    }

    public function status_class()
    {
        if($this->is_locked){
            return 'm-badge--danger';
        }
        return 'm-badge--success';
    }

    public function loginType()
    {
        $typeText = null;
        if ($this->has_password) {
            $typeText = User::LOGIN_TYPE['NORMAL'];
        }

        if (!empty($this->fb_uid)) {
            if (empty($typeText)) {
                $typeText = User::LOGIN_TYPE['FACEBOOK'];
            } else {
                $typeText .= ', ' . User::LOGIN_TYPE['FACEBOOK'];
            }
        }

        if (!empty($this->google_uid)) {
            if (empty($typeText)) {
                $typeText = User::LOGIN_TYPE['GOOGLE_PLUS'];
            } else {
                $typeText .= ', ' . User::LOGIN_TYPE['GOOGLE_PLUS'];
            }
        }

        if (empty($typeText)) {
            return User::LOGIN_TYPE['UNKNOWN'];
        }

        return $typeText;
    }


    public function disableRole()
    {
        if (empty($this->email)) {
            return false;
        }
        return true;
    }

    public function allPermissions()
    {
        $result = [];
        //check if user is super admin
        $email = $this->email;
        if (in_array($email, config('constants.SUPER_ADMIN'))) {
            foreach (Role::PERMISSIONS as $name => $permission) {
                $result[$permission] = true;
            }
        } else {
            //save user's permissions after login
            if(isset($this->role->permissions)){
                $permissions = explode(',', $this->role->permissions);
                foreach ($permissions as $permission) {
                    $result[$permission] = true;
                }
            }

        }

        return $result;
    }
}
