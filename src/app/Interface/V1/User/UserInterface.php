<?php

namespace App\Interface\V1\User;

use App\Models\User;
use Illuminate\Http\Request;

interface UserInterface
{
    /**
     * return user by given column name.
     * @param string $column
     * @param mixed $value
     */
    public function getUserBy(string $column ,mixed $value);

    /**
     * add subscription to user with passed days.
     * @param User $user
     * @param int $addition
     * @param string $addType
     */
    public function addSubscription(User $user, int $addition, string $addType = 'day');

    /**
     * check referral code is valid or not.
     * @param null|string $referral_code
     */
    public function checkReferralCode(null|string $referral_code);

    /**
     * get user as parameter and change token and return token.
     * @param User $user
     */
    public function changeUserToken(User $user);

    /**
     * user registration.
     * @param string $area_code
     * @param string $mobile_number
     * @param null|string $referral_code
     */
    public function registerUser(string $area_code, string $mobile_number, null|string $referral_code);

    /**
     * check is user registered by referral code and add free subscription.
     * @param User $user
     * @param string $type
     * @param int $addDays
     */
    public function encourageRefer(User $user, string $type, int $addDays);

    /**
     * get all user data.
     * @param Request $request
     */
    public function getUserData(Request $request);

    /**
     * save google fcm refresh token
     * @param User $user
     * @param string $token
     */
    public function saveFcmToken(User $user, string $token);
}
