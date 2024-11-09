<?php

class Captcha {
	private function Curl($postParameter)
	{
		while(true){
			$ch = curl_init("https://api-iewil.my.id/"); // URL Endpoint
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  // Save response in variable
			curl_setopt($ch, CURLOPT_POST, true);             // Use POST method
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postParameter); // Send POST data
			$response = curl_exec($ch);
			curl_close($ch);
			if($response){
				return $response;
			}else{
				print "Check your Connection!";
				sleep(2);
				print "\r                         \r";
			}
		}
	}
	
	private function Turnstile($apikey, $pageurl, $sitekey)
	{
		$postParameter = http_build_query([
			"apikey" => $apikey,
			"method" => "turnstile",
			"pageurl" => $pageurl,
			"sitekey" => $sitekey
		]);

		$response = json_decode(self::Curl($postParameter),1);
		if(!$response['status'])return 0;
		return response['result'];
	}
	
	private function Altcaptcha($apikey, $signature, $salt, $challenge)
	{
		$postParameter = http_build_query([
			"apikey" => $apikey,
			"method" => "altcha",
			"signature" => $signature,
			"salt" => $salt,
			"challenge" => $challenge
		]);
		
		$response = json_decode(self::Curl($postParameter),1);
		if(!$response['status'])return 0;
		return response['result'];
	}
	
	private function Gpcaptcha($apikey, $src)
	{
		$postParameter = http_build_query([
			"apikey" => $apikey,
			"method" => "gp",
			"main" => base64_encode($src)
		]);

		$response = json_decode(self::Curl($postParameter),1);
		if(!$response['status'])return 0;
		return response['result'];
	}
	
	private function IconCaptcha($apikey, $host, $header)
	{
		$data["apikey"] = $apikey;
		$data["method"] = "icon";
		$cap = json_decode(curl(host.'system/libs/captcha/request.php',h(1),"cID=0&rT=1&tM=light")[1],1);
		foreach($cap as $c){
			$data[$c] = base64_encode(curl(host.'system/libs/captcha/request.php?cid=0&hash='.$c, h(0,1))[1]);
		}
		$postParameter = http_build_query($data);
		$response = json_decode(self::Curl($postParameter),1);
		if(!$response['status'])return 0;
		$res=curl(host.'system/libs/captcha/request.php',h(1),"cID=0&pC=".$response['result']."&rT=2",'',1)[1];
		return response['result'];
	}
	
	private function Antibotlinks($apikey, $source)
	{
		$data["apikey"] = $apikey;
		$data["method"] = "antibot";
		$main = explode('"',explode('src="',explode('Bot links',$source)[1])[1])[0];
		$data["main"] = $main;
		$src = explode('rel=\"',$source);
		foreach($src as $x => $sour){
			if($x == 0)continue;
			$no = explode('\"',$sour)[0];
			$img = explode('\"',explode('src=\"',$sour)[1])[0];
			$data[$no] = $img;
		}
		$postParameter = json_encode($data);

		$response = json_decode(self::Curl($postParameter),1);
		if(!$response['status'])return 0;
		$cap = $response['result']['solution'];
		return "+".str_replace(",", "+", $cap);;
	}
}