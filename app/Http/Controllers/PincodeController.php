<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PincodeController extends Controller
{
    public function fetchAddress(Request $request)
    {
        $pincode = $request['id'];

        try
        {
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://pincode.p.rapidapi.com/",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "{\"searchBy\":\"pincode\",\"value\":$pincode}",
                CURLOPT_HTTPHEADER => array(
                    "accept: application/json",
                    "content-type: application/json",
                    "x-rapidapi-host: pincode.p.rapidapi.com",
                    "x-rapidapi-key: f2bd763efbmshdce5158f5b57b05p18f6e8jsn42d2df2de7da"
                ),
            ));

            $response = curl_exec($curl);

            $response = json_decode($response);

            $individualAddressValue = array();

            foreach($response as $result)
            {
                $addressValue =  $result->office.'|'.$result->taluk.'| '.$result->taluk.'|'.$result->district.'|'.$result->circle.'|'.$result->pin;
                array_push($individualAddressValue, $addressValue);
            }

            $err = curl_error($curl);

            curl_close($curl);

            if($err){
                return "cURL Error #:" . $err;
            }else{
                return $individualAddressValue;
            }
        }
        catch (\Exception $e)
        {
            $err ='Failed';
            return $err;
        }
    }
}