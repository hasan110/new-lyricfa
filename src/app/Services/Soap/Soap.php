<?php
namespace App\Services\Soap;

use Exception;
use SoapClient;
use SoapFault;

class Soap
{
    private static Soap $instance;
    private static SoapClient $soap_client;

    /**
     * @throws SoapFault
     */
    public static function getInstance($url): Soap
    {
        self::$soap_client = new SoapClient($url, [
            'exceptions' => true
        ]);
        if (!self::$instance) self::$instance = new self();
        return self::$instance;
    }

    /**
     * send otp code to passed phone number
     * @param string $phone_number
     * @param int $activate_code
     * @return void
     * @throws Exception
     */
    public static function sendOtpCodeSMS(string $phone_number , int $activate_code): void
    {
        try {
            $username = config('lyric.modir_payamak.username');
            $password = config('lyric.modir_payamak.password');
            $from_number = config('lyric.modir_payamak.from_number');
            $input_data = array(
                "verification-code" => $activate_code,
                "name" => ""
            );
            $response = self::$soap_client->sendPatternSms($from_number, array($phone_number), $username, $password, config('lyric.modir_payamak.pattern_code'), $input_data);
            $result = json_decode($response , true);

            if(is_array($result)){
                throw new Exception(__('messages.error_send_otp_code'));
            }
        }catch (Exception $e){
            throw new Exception($e->getMessage());
        }
    }
}
