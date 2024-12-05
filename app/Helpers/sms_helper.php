<?php

namespace App\Helpers;

use App\Models\OTPConfiguration;
use Twilio\Rest\Client;


class sms_helper
{

    public static function verificationsms($mobile, $otp)
    {
        try {
            $getconfiguration = OTPConfiguration::where('status', 1)->first();
            if (!empty($getconfiguration)) {
                if ($getconfiguration->name == "twilio") {
                    $sid    = $getconfiguration->twilio_sid;
                    $token  = $getconfiguration->twilio_auth_token;
                    $twilio = new Client($sid, $token);
                    $message = $twilio->messages->create($mobile, array("from" => $getconfiguration->twilio_mobile_number, "body" => "Your Verification Code is : " . $otp));
                }
                if ($getconfiguration->name == "msg91") {
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => "https://api.msg91.com/api/v5/otp?template_id=" . $getconfiguration->msg_template_id . "&mobile=" . $mobile . "&authkey=" . $getconfiguration->msg_authkey . "",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 30,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => "GET",
                        CURLOPT_HTTPHEADER => array("content-type: application/json"),
                    ));
                    $response = curl_exec($curl);
                    $err = curl_error($curl);
                    curl_close($curl);
                }
                return 1;
            }
            return 0;
        } catch (\Throwable $th) {
            return 0;
        }
    }

    public static function order_status_sms($mobile, $name, $title, $message_text)
    {
        try {
            $getconfiguration = OTPConfiguration::where('status', 1)->first();

            if (!empty($getconfiguration)) {
                if ($getconfiguration->name == "twilio") {
                    $sid    = $getconfiguration->twilio_sid;
                    $token  = $getconfiguration->twilio_auth_token;
                    $twilio = new Client($sid, $token);
                    $message = $twilio->messages->create($mobile, array("from" => $getconfiguration->twilio_mobile_number, "body" => trans('labels.dear') . $name . " " . $message_text));
                }
                if ($getconfiguration->name == "msg91") {
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => "https://api.msg91.com/api/v5/otp?template_id=" . $getconfiguration->msg_template_id . "&mobile=" . $mobile . "&authkey=" . $getconfiguration->msg_authkey . "",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 30,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => "GET",
                        CURLOPT_HTTPHEADER => array("content-type: application/json"),
                    ));
                    $response = curl_exec($curl);
                    $err = curl_error($curl);
                    curl_close($curl);
                }
                return 1;
            }
            return 0;
        } catch (\Throwable $th) {
            return 0;
        }
    }
}
