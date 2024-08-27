<?php
namespace App\Http\Controllers\API\V1\Core;

use App\Models\Core\Setting;
use IPPanel\Client;
use IPPanel\Errors\Error;
use IPPanel\Errors\HttpException;

class SMSController{

    private $sms;
    private $apiKey;
    private $number;

    public function __construct(){
        $apiKey = Setting::where('meta_key','sms_apikey')->first();
        $number = Setting::where('meta_key','sms_number')->first();
        if($apiKey != null){
            $this->apiKey = $apiKey->meta_value;
        }else{
            $this->apiKey = "CeoBE4PkU7YrqVisCBBNlVhseOnmi1g4EmJpaw8sz_U=";
        }
        if($number != null){
            $this->number = $number->meta_value;
        }else{
            $this->number = "+98100020400";
        }
    }	

    public function getCredit(){
        $client = new Client($this->apiKey);
        $credit = $client->getCredit();
        return $credit;
    }

    public function sendToMany($recipients = null, $message = null){

        try{
            if($recipients == null) return false;
            if($message == null) return false;
            $client = new Client($this->apiKey);
            $bulkID = $client->send(
                $this->number,
                $recipients,
                $message
            );
            return $bulkID;
        } catch (Error $e) {
            return $e;
        }
    }

    public function getSendInfo($bulkID = null){
        try{
            if($bulkID == null) return false;
            $client = new Client($this->apiKey);
            $message = $client->get_message($bulkID);
            return $message;
        }catch (Error $e) {
            return false;
        }
    }

    public function verifyCode(float $recipient, $code){
        try{
            if($recipient == null) return false;
            if($code == null) return false;
            $client = new Client($this->apiKey);
            $patternValues = [
                "code" => "{$code}",
            ];
            
            $bulkID = $client->sendPattern(
                "b4ags289bv",
                $this->number,
                "+98{$recipient}",
                $patternValues
            );
            return $bulkID;
        } catch (Error $e) {
            return "Error {$e}";
        }
    }

    public function newPassword(float $recipient, $code){
        try{
            if($recipient == null) return false;
            if($code == null) return false;
            $client = new Client($this->apiKey);
            $patternValues = [
                "password" => "{$code}",
            ];
            
            $bulkID = $client->sendPattern(
                "n9q9h9s71q",
                $this->number,
                "+98{$recipient}",
                $patternValues
            );
            return $bulkID;
        } catch (Error $e) {
            return "Error {$e}";
        }
    }
}