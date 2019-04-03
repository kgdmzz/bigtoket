<?php

        function read ($length='255') 
        { 
                if (!isset ($GLOBALS['StdinPointer'])) 
                { 
                $GLOBALS['StdinPointer'] = fopen ("php://stdin","r"); 
                } 
                $line = fgets ($GLOBALS['StdinPointer'],$length); 
                return trim ($line); 
        } 
		function curl($url, $params, $cookie, $header, $httpheaders, $request = 'POST', $socks = "")
        {
                $ch = curl_init();
                        
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $request);

                if($cookie == true)
                {       
                        $cookies = tempnam('/tmp','cookie.txt');
                        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookies);
                        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookies);
                }

                curl_setopt($ch, CURLOPT_HEADER, $header);
                @curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheaders);

                curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
                curl_setopt($ch, CURLOPT_PROXY, $socks);
                curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS4);

                curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
                $response = curl_exec($ch);
                return $response;
                curl_close($ch);
        }


        function registerAccount($email,$referralCode)
        {
                $headers = array();
                $headers[] = "Accept: application/json";
                $headers[] = "User-Agent: Redmi ".rand(00000,999999)." Plus_".rand(00,99).".1.2_1.0.".rand(00,99);
                $headers[] = "Host: api.bigtoken.com";
                $register = curl("https://api.bigtoken.com/signup", 'email='.$email.'&password=Abcdefg123!&referral_id='.$referralCode.'&monetize=1', false, false, $headers);
                if(strpos($register, '"message": "Too Many Attempts."'))
                {
                        return "\r\"message\": \"Too Many Attempts.\"";
                        $this->register($referralCode);
                }elseif(strpos($register, '"user_id":')){
                        return PHP_EOL."Success Register || ".$register.PHP_EOL. " || ".$email.PHP_EOL;
                }else{
                        return PHP_EOL.$register.PHP_EOL;
                }
        }
        
echo "[?] Referral Code : ";
$referralCode = read();
echo "[?] list          : ";
$list = read();
echo "\n";
$file = file_get_contents($list);
$data = explode("\n",$file);
for($a=0;$a<count($data);$a++){
    $email =  $data[$a];
    echo "[+] ".registerAccount($email,$referralCode)."\n";

}
