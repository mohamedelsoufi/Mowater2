<?php
const PAGINATION_COUNT = 15;

function responseJson($status, $msg, $data = [])
{
    return response()->json(['status' => $status, 'msg' => $msg, 'data' => $data], 200);
}

function sms()
{
//Please Enter Your Details
    $user = "Menna"; //your username
    $password = "123456"; //your password
    $mobilenumbers = "2001010309819"; //enter Mobile numbers comma seperated
    $message = "test messgae"; //enter Your Message
    $senderid = "smscntry"; //Your senderid
    $messagetype = "N"; //Type Of Your Message
    $DReports = "Y"; //Delivery Reports
    $url = "http://www.smscountry.com/SMSCwebservice_Bulk.aspx";
    $message = urlencode($message);
    $ch = curl_init();
    if (!$ch) {
        die("Couldn't initialize a cURL handle");
    }
    $ret = curl_setopt($ch, CURLOPT_URL, $url);
//    return $ret;

    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_POSTFIELDS,
        "User=$user&passwd=$password&mobilenumber=$mobilenumbers&message=$message&sid=$senderid&mtype=$messagetype&DR=$DReports");
    $ret = curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//If you are behind proxy then please uncomment below line and provide your proxy ip with port.
// $ret = curl_setopt($ch, CURLOPT_PROXY, "PROXY IP ADDRESS:PORT");
//    return $ch;
    $curlresponse = curl_exec($ch); // execute
    if (curl_errno($ch))
        return 'curl error : ' . curl_error($ch);
    if (empty($ret)) {
// some kind of an error happened
        die(curl_error($ch));
        curl_close($ch); // close cURL handler
    } else {
        $info = curl_getinfo($ch);
        curl_close($ch); // close cURL handler
        return $curlresponse; //echo "Message Sent Succesfully" ;
    }
}
