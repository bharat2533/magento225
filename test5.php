<?php
function sign($method, $url, $data, $consumerSecret, $tokenSecret)
{
	$url = urlEncodeAsZend($url);
 
	$data = urlEncodeAsZend(http_build_query($data, '', '&'));
	$data = implode('&', [$method, $url, $data]);
 
	$secret = implode('&', [$consumerSecret, $tokenSecret]);
 
	return base64_encode(hash_hmac('sha1', $data, $secret, true));
}
 
function urlEncodeAsZend($value)
{
	$encoded = rawurlencode($value);
	$encoded = str_replace('%7E', '~', $encoded);
	echo "<pre>"; print_r($encoded); die()
	return $encoded;
}
 
// REPLACE WITH YOUR ACTUAL DATA OBTAINED WHILE CREATING NEW INTEGRATION
$consumerKey = '4pad3ak85qus91xt5dccw1am42ygm9at';
$consumerSecret = '4qd3r1y7cplxcm4sd3n3n7097v4wh23d';
$accessToken = 'tvtqq6nh1hotpo2mf5e9o1ipyusr08bm';
$accessTokenSecret = '2myngrfbxl7bs0wqsu6bt7xcgbqyhsks';
 
$method = 'GET';
$url = 'http://magento.m2/index.php/rest/V1/customers/2';
 
//
$data = [
	'oauth_consumer_key' => $consumerKey,
	'oauth_nonce' => md5(uniqid(rand(), true)),
	'oauth_signature_method' => 'HMAC-SHA1',
	'oauth_timestamp' => time(),
	'oauth_token' => $accessToken,
	'oauth_version' => '1.0',
];
 
$data['oauth_signature'] = sign($method, $url, $data, $consumerSecret, $accessTokenSecret);
 
$curl = curl_init();
 
curl_setopt_array($curl, [
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => $url,
	CURLOPT_HTTPHEADER => [
		'Authorization: OAuth ' . http_build_query($data, '', ',')
	]
]);
 
$result = curl_exec($curl);
curl_close($curl);
var_dump($result);