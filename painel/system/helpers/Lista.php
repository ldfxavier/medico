<?php
    class Lista {
        /**
         * LISTA DE ESTADOS BRASILEIRO
        **/
        public static function estado($titulo = null, $sigla = false, $maiusculo = false){
            $lista_completo = array('AC' => 'Acre','AL' => 'Alagoas','AP' => 'Amapá','AM' => 'Amazonas','BA' => 'Bahia','CE' => 'Ceará','DF' => 'Distrito Federal','ES' => 'Espírito Santo','GO' => 'Goiás','MA' => 'Maranhão','MT' => 'Mato Grosso','MS' => 'Mato Grosso do Sul','MG' => 'Minas Gerais','PA' => 'Pará','PB' => 'Paraíba','PR' => 'Paraná','PE' => 'Pernambuco','PI' => 'Piauí','RJ' => 'Rio de Janeiro','RN' => 'Rio Grande do Norte','RS' => 'Rio Grande do Sul','RO' => 'Rondônia','RR' => 'Roraima','SC' => 'Santa Catarina','SP' => 'São Paulo','SE' => 'Sergipe','TO' => 'Tocantins');
            $lista_sigla = array('AC' => 'AC','AL' => 'AL','AP' => 'AP','AM' => 'AM','BA' => 'BA','CE' => 'CE','DF' => 'DF','ES' => 'ES','GO' => 'GO','MA' => 'MA','MT' => 'MT','MS' => 'MS','MG' => 'MG','PA' => 'PA','PB' => 'PB','PR' => 'PR','PE' => 'PE','PI' => 'PI','RJ' => 'RJ','RN' => 'RN','RS' => 'RS','RO' => 'RO','RR' => 'RR','SC' => 'SC','SP' => 'SP','SE' => 'SE','TO' => 'TO');

            $lista = ($sigla == true) ? $lista_sigla : $lista_completo;
            if($sigla == false & $maiusculo == true):
                $tmp = array();
                foreach($lista as $ind => $val) $tmp[$ind] = Converter::caixa($val, 'A');
                $lista = $tmp;
            endif;
            $array = array();
            if($titulo) foreach($titulo as $ind => $val) $array[$ind] = $val;
            if($lista) foreach($lista as $ind => $val) $array[$ind] = $val;
            return $array;
        }

		public static function status($titulo = null){
			if(!empty($titulo)) $select[''] = $titulo;
			$select['1'] = 'Ativo';
			$select['2'] = 'Inativo';
			return $select;
		}
    }
