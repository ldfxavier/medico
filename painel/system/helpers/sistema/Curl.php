<?php
    final class Curl {
        /**
         * ENVIA NORMAL
        **/
        public static function normal($url, $json = true){
            $curl = curl_init(str_replace(' ', '+', $url));
    		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    		if($json) curl_setopt($curl, CURLOPT_HTTPHEADER , array('Accept: application/json'));

            if($json == true) return json_decode(curl_exec($curl), false);
            else return curl_exec($curl);
        }

        /**
         * ENVIA COM POST
        **/
        public static function post($url, $dados, $json = true){
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($dados));
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
            if($json) curl_setopt($curl, CURLOPT_HTTPHEADER , array('Accept: application/json'));

            if($json == true) return json_decode(curl_exec($curl), false);
            else return curl_exec($curl);
        }

    }
