<?php

namespace App\Repository\V1\User;

use App\Exceptions\Throwable\BaseException;
use App\Interface\V1\User\UserInterface;
use App\Jobs\SendNotification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserRepository implements UserInterface
{
    private array $valid_columns = [
        'id',
        'code_introduce'
    ];

    /**
     * get user by passed column
     * @param string $column
     * @param mixed $value
     * @return User|null
     * @throws BaseException
     */
    public function getUserBy(string $column , mixed $value): User|null
    {
        if (!in_array($column , $this->valid_columns)){
            throw new BaseException('invalid column name passed to function');
        }

        return User::where($column , $value)->first();
    }

    /**
     * get user by mobile and prefix code
     * @param string $prefix_code
     * @param string $phone_number
     * @return User|null
     */
    public function getUserByMobile(string $prefix_code, string $phone_number): User|null
    {
        return User::where('prefix_code' , $prefix_code)->where('phone_number' , $phone_number)->first();
    }

    /**
     * add subscription to user with passed days.
     * @param User $user
     * @param int $addition
     * @param string $addType
     * @return User
     */
    public function addSubscription(User $user, int $addition, string $addType = 'day'): User
    {
        if (!isset($user->id)) return $user;

        if ($user->expired_at > Carbon::now()) {
            if ($addType === 'day') {
                $new_expiry = Carbon::parse($user->expired_at)->addDays($addition);
            } else {
                $new_expiry = Carbon::parse($user->expired_at)->addMinutes($addition);
            }
        } else {
            if ($addType === 'day') {
                $new_expiry = Carbon::now()->addDays($addition);
            } else {
                $new_expiry = Carbon::now()->addMinutes($addition);
            }
        }

        $user->expired_at = $new_expiry;
        $user->save();

        return $user;
    }

    /**
     * validate referral code and return it if be valid.
     * @param null|string $referral_code
     * @return string|null
     */
    public function checkReferralCode(null|string $referral_code): null|string
    {
        return User::query()->where('code_introduce' , $referral_code)->exists() ? $referral_code : null;
    }

    /**
     * get user as parameter and change token and return token.
     * @param User $user
     * @return string
     */
    public function changeUserToken(User $user): string
    {
        $user->tokens()->delete();
        $token = $user->createToken(config('app.name'));
        return $token->plainTextToken;
    }

    /**
     * user registration.
     * @param string $prefix_code
     * @param string $phone_number
     * @param null|string $referral_code
     * @return User
     * @throws BaseException
     */
    public function registerUser(string $prefix_code, string $phone_number, null|string $referral_code): User
    {
        do{
            $code_introduce = Str::random(6);
            $code_introduce_exists = User::query()->where('code_introduce' , $code_introduce)->exists();
        }while($code_introduce_exists);

        $user = new User();
        $user->phone_number = $phone_number;
        $user->prefix_code = $prefix_code;
        $user->expired_at = Carbon::now()->addDays(2); // Free subscription
        $user->code_introduce = $code_introduce;
        $user->referral_code = $referral_code;
        $user->save();

        if ($referral_code) {
            $this->encourageRefer($user);
        }

        return $user;
    }

    /**
     * check is user registered by referral code and add free subscription.
     * @param User $user
     * @param string $type
     * @param int $addDays
     * @return void
     * @throws BaseException
     */
    public function encourageRefer(User $user, string $type = 'register', int $addDays = 2): void
    {
        if(!$user->referral_code) return;

        $encouraged_user = $this->getUserBy('code_introduce' , $user->referral_code);
        if(!$encouraged_user) return;

        $number = substr($user->phone_number , 0 , 3) . '***' . substr($user->phone_number , -4);

        switch ($type){
            case 'register':
                $message = sprintf('شما کاربر %u را به اپلیکیشن لیریکفا معرفی کردید. به ازای آن %s روز اشتراک رایگان دریافت کردید که هم اکنون میتوانید استفاده کنید.' , $number , $addDays);
                $title = 'معرفی کاربر';
                break;
            case 'subscription':
                $message = sprintf('شما از معرفی کاربر %u و خرید اشتراک توسط این کاربر، %s روز اشتراک رایگان دریافت کردید که هم اکنون میتوانید استفاده کنید.' , $number , $addDays);
                $title = 'اشتراک رایگان';
                break;
            default:
                return;
        }

        SendNotification::dispatch([
            'title' => $title,
            'body' => $message,
            'token' => $encouraged_user->fcm_refresh_token,
        ]);

        $this->addSubscription($encouraged_user, $addDays);
    }

    /**
     * get all user data.
     * @param Request $request
     * @return User
     */
    public function getUserData(Request $request): User
    {
        $user = User::select(['phone_number' , 'code_introduce' , 'referral_code' , 'fcm_refresh_token' , 'expired_at' , 'created_at' , 'updated_at'])
            ->where('id' , $request->user()->id)
            ->first();

        if(!$user){
            return $request->user();
        }

        $now = Carbon::now();
        $expiredAt = $user->expired_at;

        if($now > $expiredAt){
            $user->days_remain = 0;
            $user->hours_remain = 0;
            $user->minutes_remain = 0;
        }else{
            $user->days_remain = $now->diffInDays($expiredAt);
            $user->hours_remain = $now->diffInHours($expiredAt);
            $user->minutes_remain = $now->diffInMinutes($expiredAt);
        }

        return $user;
    }

    /**
     * save google fcm refresh token
     * @param User $user
     * @param string $token
     * @return User $user
     */
    public function saveFcmToken(User $user , string $token): User
    {
        $user->fcm_refresh_token = $token;
        $user->save();
        return $user;
    }
}
