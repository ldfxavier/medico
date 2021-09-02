<?php

namespace App\Helpers;

final class Data {

	public function formato($formato = 'd/m/Y H:i:s'){

		if(!$this->validar()):
			return '';
		endif;

		$data = $this->retorno;

		return $data->format($formato);

	}

	public function nome_mes(){

	}

	public function nome_semana(){

	}

	public function diferenca($comparar){

	}

	public function idade($comparar){

	}

	public function adicionar($numero, String $tempo = ''){

		if(!$this->validar()):
			return '';
		endif;

		$tempo = $numero.' '.$tempo;
		$date = $this->retorno;

		$this->retorno = date_add($date, date_interval_create_from_date_string($tempo));

		return $this;

	}
	public function remover($numero, String $tempo = ''){

		if(!$this->validar()):
			return '';
		endif;

		$tempo = $numero.' '.$tempo;
		$date = $this->retorno;

		$this->retorno = date_sub($date, date_interval_create_from_date_string($tempo));

		return $this;

	}


	/*
	|--------------------------------------------------------------------------
	| BASE DA CLASSE
	|--------------------------------------------------------------------------
	|
	| Métodos e propriedades base da classe como getters, setters, validações,
	| construtores e demais métodos para o bom funcionamento da classe,
	| não alterar ou remover nenhum dos métodos ou propriedades
	|
	*/

	private $retorno;
	private $replace_data_br;
	private $replace_data_eua = [];

	public function __construct($valor = null){

		$this->replace_data_br = ['anos', 'ano', 'meses', 'mes', 'semanas', 'semana', 'dias', 'dia', 'horas', 'hora', 'minutos', 'minuto', 'segudos', 'segundo'];
		$this->replace_data_eua = ['year', 'year', 'month', 'month', 'week', 'week', 'day', 'day', 'hour', 'hour', 'minute', 'minute', 'second', 'second'];

	}

	public function __toString(){

		$retorno = (string)$this->retorno;
		$this->retorno = '';

		if(!empty($retorno)):
			return $retorno;
		endif;

		return '';

	}

	public function r(){

		if(!$this->validar()):
			return '';
		endif;

		$retorno = $this->retorno;
		$this->retorno = '';

		return $retorno;

	}

	public function valor($data = null){

		if(
			empty($data) ||
			in_array($data, ['00/00/0000', '00/00/0000 00:00:00', '0000-00-00', '0000-00-00 00:00:00']) ||
			(
				!preg_match('/^(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/([0-9]{4})$/', $data) &&
				!preg_match('/^([0-9]{4})-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $data) &&
				!preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/[0-9]{4}\ ([0-1][0-9]|2[0-3]):(0[0-9]|[1-5][0-9]):(0[0-9]|[1-5][0-9])$/", $data) &&
				!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])\ ([0-1][0-9]|2[0-3]):(0[0-9]|[1-5][0-9]):(0[0-9]|[1-5][0-9])$/", $data)
			)
		):
			$this->retorno = null;
			return $this;
		endif;

		$this->retorno = new \DateTime(str_replace('/', '-', $data));

		return $this;

	}

	private function validar(){

		if(!$this->retorno instanceof \DateTime):
			$this->retorno = null;
			return false;
		endif;

		return true;

	}
}