<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'mef_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function setHashkey()
    {
        $this->hashkey = $this->checkHashkey();
    }

    /**
     * @return string
     */
    public function checkHashkey()
    {
        $hash = $this->mt_rand_str(10, '0123456789abcdef');
        $has_key = $this::where('hashkey', '==', $hash)->take(1)->count();
        if ($has_key) {
            return $this->checkHashkey();
        } else {
            return $hash;
        }
    }

    public function setConfirmCode()
    {
        $this->confirmation_code = $this->checkConfirmCode();
    }

    public function checkConfirmCode()
    {
        $confirmation = $this->mt_rand_str(20, '0123456789abcdefghijklmnopqrstuvwxyz');
        $confirmation_code = $this::where('confirmation_code', '==', $confirmation)->take(1)->count();
        if ($confirmation_code) {
            return $this->checkConfirmCode();
        } else {
            return $confirmation;
        }
    }

    public function setResetPwCode()
    {
        $this->reset_pw_code = $this->checkResetPwCode();
    }

    public function checkResetPwCode()
    {
        $reset_pw = $this->mt_rand_str(20, '0123456789abcdefghijklmnopqrstuvwxyz');
        $reset_pw_code = $this::where('reset_pw_code', '==', $reset_pw)->take(1)->count();
        if ($reset_pw_code) {
            return $this->checkResetPwCode();
        } else {
            return $reset_pw;
        }
    }

    /**
     * @param $l
     * @param string $c
     * @return string
     */
    function mt_rand_str($l, $c = 'abcdefghijklmnopqrstuvwxyz1234567890')
    {
        for ($s = '', $cl = strlen($c) - 1, $i = 0; $i < $l; $s .= $c[mt_rand(0, $cl)], ++$i) ;
        return $s;
    }
}
