<?php
include("weather_constants.php");
/**
 * 
 */
class Awhere
{
    protected $api_key;
    protected $api_secret;

    public function __construct()
    {
        $this->api_key      = AWHERE_KEY;
        $this->api_secret   = AWHERE_SECRET;
    }

    public function makeAPICall($verb, $url, $token, &$responseStatusCode=null, &$responseHeaders=null, $body=null, $headers=null){ 
        
        if($headers!==null){ 
            $headers[] = "Authorization: Bearer $token"; 
        } else { 
            $headers = array("Authorization: Bearer $token"); 
        } 
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $verb);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);

        if(($verb=='POST' || $verb=='PUT' || $verb=='PATCH') && !is_null($body))
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body); 
         curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = curl_exec($ch);
        if($response === false){
            throw new Exception('cURL Transport Error (HTTP request failed): '.curl_error($ch));
            $responseStatusCode = false; 
        } else { 
            $info = curl_getinfo($ch);
            $responseStatusCode = $info['http_code']; 
            list($responseHeaders, $body) = explode("\r\n\r\n", $response, 2); 
            $result = json_decode($body); 
        }   
        curl_close($ch);
        
        return $result;
    } 

    public function GetOAuthToken(){
        
        $ch = curl_init("https://api.awhere.com/oauth/token");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                                    "Content-Type: application/x-www-form-urlencoded",
                                                    "Authorization: Basic ".base64_encode($this->api_key.":".$this->api_secret)
                                                ));

         curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = curl_exec($ch);
        
        if($response === false){
            throw new Exception('cURL Transport Error (HTTP request failed): '.curl_error($ch));
            $responseStatusCode = false; 
        } else { 
            $info = curl_getinfo($ch);
            $responseStatusCode = $info['http_code']; 
            $result = json_decode($response); 
        }   
        curl_close($ch);
        
        if (isset($responseStatusCode) && $responseStatusCode != 200) {
            return [
                'status'    => false,
                'message'   => 'Error'.$result->statusCode.' '.$result->simpleMessage
            ];
        }
        elseif(isset($responseStatusCode) && $responseStatusCode == 200){
            return [
                'status'    => true,
                'message'   => 'success',
                'access_token' => $result->access_token
            ];
        }else{
            return [
                'status'    => false,
                'message'   => 'No response'
            ];
        }
    }

    public function parseHTTPHeaders($raw, $desired, $returnType = 'string'){ 
        $listed = explode("\n",$raw); 
        $parsed = array(); 
        $return = array(); 

        foreach($listed as $line){ 
            if(substr($line,0,4)=='HTTP') continue; 
            list($key,$value) = explode(': ',$line); 
            $parsed[$key] = $value; 
        } 
        
        foreach($desired as $header){ 
            $return[$header] = (array_key_exists($header,$parsed)) ? $parsed[$header] : null; 
        } 
        
        if($returnType=='array'){ 
            return $return; 
        } else { 
            $output = ''; 
            foreach($return as $header=>$value){ 
                $output.=$header.': '.$value."\n"; 
            } 
            return trim($output); 
        }         
    } 

    public function fieldIdGenerator($length) {
     $pool = array_merge(range(0,9), range('a', 'z'),range('A', 'Z'));

        $key="";

        for($i=0; $i < $length; $i++) {
            $key .= $pool[mt_rand(0, count($pool) - 1)];
        }
        return $key;
    }
}