<?php


//Method 1
$payload = array(
    'to' => 'ExponentPushToken[unrk3pOs6j8hxnIG61JpKA]',
    'sound' => 'default',
    'body' => 'hello',
);

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://exp.host/--/api/v2/push/send",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => json_encode($payload),
    CURLOPT_HTTPHEADER => array(
        "Accept: application/json",
        "Accept-Encoding: gzip, deflate",
        "Content-Type: application/json",
        "cache-control: no-cache",
        "host: exp.host"
    ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    echo $response;
}



//Method 2
use ExpoSDK\Expo;
use ExpoSDK\ExpoMessage ;

/**
 * Composed messages, see above
 * Can be an array of arrays, ExpoMessage instances will be made internally
 */
$messages = [
   /* [
        'title' => 'Test notification',
        'to' => 'ExponentPushToken[unrk3pOs6j8hxnIG61JpKA]',
    ],*/
    new ExpoMessage([
        'title' => 'Notification for default recipients',
        'body' => 'Because "to" property is not defined',
    ]),
];

/**
 * These recipients are used when ExpoMessage does not have "to" set
 */
$defaultRecipients = [
    'ExponentPushToken[unrk3pOs6j8hxnIG61JpKA]',
];

(new Expo)->send($messages)->to($defaultRecipients)->push();
//(new Expo)->send($messages)->push();