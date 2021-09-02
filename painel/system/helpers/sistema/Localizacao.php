<?php
	final class Localizacao {

		/**
		 * BUSCA ENDERECO PELO CEP
		**/
		public static function cep($cep){
			$cep = preg_replace("/[^0-9]/", "", $cep);

			$ch = curl_init('http://api.postmon.com.br/v1/cep/'.$cep);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER , array('Accept: application/json'));

			$retorno = json_decode(curl_exec($ch), true);

			if($retorno && is_array($retorno)):
				return (object)array(
					'erro' => false,
					'bairro' => isset($retorno['bairro']) ? $retorno['bairro'] : '',
					'logradouro' => isset($retorno['logradouro']) ? $retorno['logradouro'] : '',
					'cidade' => isset($retorno['cidade']) ? $retorno['cidade'] : '',
					'estado' => isset($retorno['estado']) ? $retorno['estado'] : '',
					'cep' => isset($retorno['cep']) ? $retorno['cep'] : ''
				);
			endif;
			return (object)array('erro' => true);
		}

		/**
		 * BUSCA A GEOLOCALIZACAO
		**/
		public static function geolocalizacao($endereco){
			if(empty($endereco)) return array('erro' => true);
			$url = 'https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyAkKA5ZteX4i5N7kY9-sdXsWLSRTYr8L5Q&address='.urlencode($endereco);

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER , array('Accept: application/json'));

			$retorno = json_decode(curl_exec($ch), true);
			if(isset($retorno['results']['0']['geometry']['location']['lat']) && isset($retorno['results']['0']['geometry']['location']['lng'])):
				return [
					'erro' => false,
					'latitude' => $retorno['results']['0']['geometry']['location']['lat'],
					'longitude' => $retorno['results']['0']['geometry']['location']['lng']
				];
			else:
				return array('erro' => true);
			endif;
		}

		public static function geoip($ip){
			if(!filter_var($ip, FILTER_VALIDATE_IP)) return array('erro' => true);
			$url = (string)"http://ip-api.com/json/{$ip}?fields=65535";

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER , array('Accept: application/json'));

			$retorno = json_decode(curl_exec($ch), true);
			if($retorno && isset($retorno['status']) && $retorno['status'] == 'success'):
				return [
					'erro' => false,
					'pais' => isset($retorno['country']) ? $retorno['country'] : '',
					'pais_cod' => isset($retorno['countryCode']) ? $retorno['countryCode'] : '',
					'estado' => isset($retorno['regionName']) ? $retorno['regionName'] : '',
					'estado_cod' => isset($retorno['region']) ? $retorno['region'] : '',
					'cidade' => isset($retorno['city']) ? $retorno['city'] : '',
					'latitude' => isset($retorno['lat']) ? $retorno['lat'] : '',
					'longitude' => isset($retorno['lon']) ? $retorno['lon'] : '',
					'provedor' => isset($retorno['isp']) ? $retorno['isp'] : ''
				];
			else:
				return array('erro' => true);
			endif;
		}
	}
