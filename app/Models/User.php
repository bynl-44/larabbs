<?php

namespace App\Models;

use App\Models\Traits\ActiveUserHelper;
use App\Models\Traits\LastActivedAtHelper;
use Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * @property mixed id
 * @property int notification_count
 * @property mixed unreadNotifications
 * @property mixed name
 * @property mixed email
 * @property mixed avatar
 * @property mixed introduction
 * @property mixed phone
 * @property mixed weixin_unionid
 * @property mixed weixin_openid
 * @property mixed last_actived_at
 * @property mixed created_at
 * @property mixed updated_at
 * @method static create(array $array)
 * @method static where(string $string, $unionid)
 */
class User extends Authenticatable implements MustVerifyEmailContract, JWTSubject
{
    use LastActivedAtHelper;
    use ActiveUserHelper;
    use HasRoles;
    use MustVerifyEmailTrait;
    use Notifiable {
        notify as protected laravelNotify;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'phone', 'email', 'password', 'introduction', 'avatar', 'weixin_openid', 'weixin_unionid'
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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    /**
     * 权限控制
     *
     * @param $model
     * @return bool
     */
    public function isAuthorOf($model)
    {
        return $this->id == $model->user_id;
    }

    public function notify($instance)
    {
        // 如果要通知的人是当前用户，就不必通知了！
        if ($this->id == Auth::id()) {
            return;
        }

        // 只有数据库类型通知才需提醒，直接发送 Email 或者其他的都 Pass
        if (method_exists($instance, 'toDatabase')) {
            $this->increment('notification_count');
        }

        $this->laravelNotify($instance);
    }

    public function markAsRead()
    {
        $this->notification_count = 0;
        $this->save();
        $this->unreadNotifications->markAsRead();
    }

    public function setPasswordAttribute($value)
    {
        // 如果值的长度等于 60，即认为是已经做过加密的情况
        if (strlen($value) != 60) {

            // 不等于 60，做密码加密处理
            $value = bcrypt($value);
        }

        $this->attributes['password'] = $value;
    }

    public function setAvatarAttribute($path)
    {
        // 如果不是 `http` 子串开头，那就是从后台上传的，需要补全 URL
        if (!Str::startsWith($path, 'http')) {
            // 拼接完整的 URL
            $path = config('app.url') . '/uploads/images/avatars/' . $path;
        }

        $this->attributes['avatar'] = $path;
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
