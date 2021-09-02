<?php
	namespace App\Helpers;

	final class Localizacao {

		private $tipo, $endereco, $latitude, $longitude, $key, $cep;

		public function __construct(){

			$this->key = 'AIzaSyAkKA5ZteX4i5N7kY9-sdXsWLSRTYr8L5Q';
			$this->tipo = '';

		}

		public function buscar_endereco_pelo_cep(){

			if(empty($this->cep)):
				return (object)['erro' => true];
			endif;

			$ch = curl_init('https://api.postmon.com.br/v1/cep/'.$this->cep);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER , ['Accept: application/json']);

			$retorno = json_decode(curl_exec($ch), true);

			if($retorno && is_array($retorno)):
				return (object)[
					'erro' => false,
					'bairro' => isset($retorno['bairro']) ? $retorno['bairro'] : '',
					'logradouro' => isset($retorno['logradouro']) ? $retorno['logradouro'] : '',
					'cidade' => isset($retorno['cidade']) ? $retorno['cidade'] : '',
					'estado' => isset($retorno['estado']) ? $retorno['estado'] : '',
					'cep' => isset($retorno['cep']) ? $retorno['cep'] : '',
					'pais' => $endereco_pais[0] ?? ''
				];
			endif;

			return (object)['erro' => true];

		}

		public function cep($cep){

			$this->tipo = 'cep';
			$this->cep = preg_replace("/[^0-9]/", "", $cep);

			return $this;

		}

		public function endereco($endereco = ''){

			if(empty($this->tipo)):

				$this->tipo = 'endereco';

			endif;

			if($this->tipo == 'endereco'):

				$this->endereco = mb_strtolower($endereco, 'UTF-8');
				return $this;

			elseif($this->tipo == 'geolocalizacao'):

				$this->tipo = '';
				return $this->buscar_endereco_pela_geolocalizacao();

			elseif($this->tipo == 'cep'):

				$this->tipo = '';
				return $this->buscar_endereco_pelo_cep();

			endif;

		}

		private function buscar_endereco_pela_geolocalizacao(){

			if(empty($this->latitude) || empty($this->longitude)):
				return mensagem_erro('Campo obrigatório!', 'Você deve passar a latitude e longitude', 400);
			endif;

			$url = 'https://maps.google.com/maps/api/geocode/json?latlng='.$this->latitude.','.$this->longitude.'&key='.$this->key;

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER , ['Accept: application/json']);

			$retorno = json_decode(curl_exec($ch), true);

			if(!isset($retorno['results']) || empty($retorno['results'])):

				return [
					'erro' => false,
					'status_html' => 404
				];

			endif;

			$endereco = [];

			foreach($retorno['results'] as $r):

				if($r['geometry']['location']['lat'] == $this->latitude && $r['geometry']['location']['lng'] == $this->longitude):

					$endereco = $r['address_components'];

					break;

				elseif(empty($endereco_completo)):

					$endereco = $r['address_components'];

				endif;

			endforeach;

			return $this->montar_endereco($endereco);

		}

		public function geolocalizacao($latitude = '', $longitude = ''){

			if(empty($this->tipo)):

				$this->tipo = 'geolocalizacao';

			endif;

			if($this->tipo == 'geolocalizacao'):

				$this->latitude = $latitude;
				$this->longitude = $longitude;

				return $this;

			elseif($this->tipo == 'endereco'):

				$this->tipo = '';
				return $this->buscar_geolocalizacao_pelo_endereco();

			endif;

		}
		private function buscar_geolocalizacao_pelo_endereco(){

			if(empty($this->endereco)):
				return mensagem_erro('Campo obrigatório!', 'Você deve passar um endereço.', 400);
			endif;

			$endereco = $this->endereco;
			if(in_array($endereco, ['são paulo','sao paulo', 'sãopaulo', 'saopaulo'])):
				$endereco = 'são paulo/sp';
			elseif(in_array($endereco, ['rio de janeiro','riodejaneiro'])):
				$endereco = 'rio de janeiro/rj';
			elseif(in_array($endereco, ['rio branco', 'riobranco'])):
				$endereco = 'jardim nazie - rio branco/ac';
			endif;

			$url = 'https://maps.google.com/maps/api/geocode/json?address='.urlencode($endereco).'&key='.$this->key.'&region=BR&components=country:BR|language:pt-BR';

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER , ['Accept: application/json']);

			$retorno = json_decode(curl_exec($ch), true);

			if(!isset($retorno['results'][0]['formatted_address'])):

				$url = 'https://maps.google.com/maps/api/geocode/json?address='.urlencode($endereco).',&key='.$this->key.'&sensor=false&components=language:pt-BR';

				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER , ['Accept: application/json']);

				$retorno = json_decode(curl_exec($ch), true);

			endif;

			if(!isset($retorno['results'][0]['formatted_address'])):
				return [
					'erro' => false,
					'status_html' => 404
				];
			endif;

			$endereco = $this->montar_logradouro($retorno['results'][0]['address_components']);

			return [
				'erro' => false,
				'endereco' => $endereco['completo'] ?? '',
				'latitude' => $retorno['results'][0]['geometry']['location']['lat'],
				'longitude' => $retorno['results'][0]['geometry']['location']['lng']
			];

		}

		public function geoip(){

			$ip = '';

			$url = (String)"http://ip-api.com/json/{$ip}?fields=65535";

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER , ['Accept: application/json']);

			$retorno = json_decode(curl_exec($ch), true);
			if($retorno && isset($retorno['status']) && $retorno['status'] == 'success'):
				return [
					'erro' => false,
					'pais' => isset($retorno['countryCode']) ? $retorno['countryCode'] : '',
					'estado' => isset($retorno['region']) ? $retorno['region'] : '',
					'cidade' => isset($retorno['city']) ? $retorno['city'] : '',
					'latitude' => isset($retorno['lat']) ? $retorno['lat'] : '',
					'longitude' => isset($retorno['lon']) ? $retorno['lon'] : '',
					'provedor' => isset($retorno['isp']) ? $retorno['isp'] : ''
				];
			else:
				return ['erro' => true];
			endif;
		}

		private function montar_logradouro($dado){

			$endereco_logradouro = [];
			$endereco_cidade = '';
			$endereco_estado = '';
			$endereco_pais = [];
			$endereco_cep = '';

			if($dado):
				foreach($dado as $r):
					if(in_array('country', $r['types'])):
						$endereco_pais = [$r['short_name'], $r['long_name']];
					elseif(in_array('administrative_area_level_1', $r['types'])):
						$endereco_estado = $r['short_name'];
					elseif(in_array('administrative_area_level_2', $r['types'])):
						$endereco_cidade = $r['long_name'];
					elseif(in_array('postal_code', $r['types'])):
						$endereco_cep = $r['long_name'];
					else:
						$endereco_logradouro[] = $r['long_name'];
					endif;
				endforeach;
			endif;

			$endereco_logradouro = implode(', ', $endereco_logradouro);
			if($endereco_logradouro == $endereco_cidade):
				$endereco_logradouro = '';
			endif;

			$endereco_completo = $endereco_logradouro;

			if(!empty($endereco_completo) && !empty($endereco_cidade)):
				$endereco_completo .= ' - '.$endereco_cidade;
			elseif(!empty($endereco_cidade)):
				$endereco_completo = $endereco_cidade;
			endif;

			if(!empty($endereco_cidade) && !empty($endereco_estado)):
				$endereco_completo .= '/'.$endereco_estado;
			elseif(!empty($endereco_completo) && !empty($endereco_estado)):
				$endereco_completo .= ' - '.$endereco_estado;
			endif;

			if(!empty($endereco_completo) && !empty($endereco_cep)):
				$endereco_completo .= ' - CEP: '.$endereco_cep;
			endif;
			if(!empty($endereco_completo) && isset($endereco_pais[1]) && !empty($endereco_pais[1])):
				$pais = [
					'Germany' => 'Alemanha',
					'Belgium' => 'Bélgica',
					'Australia' => 'Austrália',
					'Bolivia' => 'Bolívia',
					'Brazil' => 'Brasil',
					'Canada' => 'Canadá',
					'Colombia' => 'Colômbia',
					'Korea' => 'Coréia',
					'Ecuador' => 'Equador',
					'Spain' => 'Espanha',
					'The United States of America' => 'EUA',
					'Denmark' => 'Dinamarca',
					'France' => 'França',
					'Greece' => 'Grécia',
					'England' => 'Inglaterra',
					'Italy' => 'Itália',
					'Japan' => 'Japão',
					'Norway' => 'Noruega',
					'Paraguay' => 'Paraguai',
					'México' => 'Mexico',
					'Peru' => 'Perú',
					'Russia' => 'Rússia',
					'Sweden' => 'Suécia',
					'Uruguay' => 'Uruguai',
					'Iran' => 'Irã',
					'Iraq' => 'Iraque',
					'Egypt' => 'Egito',
					'Turkey' => 'Turquia',
					'Thailand' => 'Tailândia'
				];
				$endereco_completo .= ' - '.str_replace(array_keys($pais), array_values($pais), $endereco_pais[1]);
			endif;

			return [
				'erro' => false,
				'completo' => $endereco_completo,
				'cep' => preg_replace("/[^0-9]/", "", $endereco_cep),
				'logradouro' => $endereco_logradouro,
				'cidade' => $endereco_cidade,
				'estado' => $endereco_estado,
				'pais' => $endereco_pais[0] ?? ''
			];

		}

	}
