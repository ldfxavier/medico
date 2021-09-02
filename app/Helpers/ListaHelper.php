<?php
    namespace app\Helpers;
    final class Lista {
        private $lista, $tipo;
        public function r(){
            $valor = $this->lista;
            $this->lista = '';
            return $valor;
        }
        public function add($array){
            $lista = $this->lista;
            if(is_array($lista) && $lista) $this->lista = array_merge($lista, $array);
            else $this->lista = $array;
            return $this;
        }
        public function estado($indice = 'UF'){
			
			$estado = ['AC' => 'Acre','AL' => 'Alagoas','AP' => 'Amapá','AM' => 'Amazonas','BA' => 'Bahia','CE' => 'Ceará','DF' => 'Distrito Federal','ES' => 'Espírito Santo','GO' => 'Goiás','MA' => 'Maranhão','MT' => 'Mato Grosso','MS' => 'Mato Grosso do Sul','MG' => 'Minas Gerais','PA' => 'Pará','PB' => 'Paraíba','PR' => 'Paraná','PE' => 'Pernambuco','PI' => 'Piauí','RJ' => 'Rio de Janeiro','RN' => 'Rio Grande do Norte','RS' => 'Rio Grande do Sul','RO' => 'Rondônia','RR' => 'Roraima','SC' => 'Santa Catarina','SP' => 'São Paulo','SE' => 'Sergipe','TO' => 'Tocantins'];
			if('nome' == mb_strtolower($indice, 'UTF-8')):
				$estado = ['Acre' => 'Acre','Alagoas' => 'Alagoas','Amapá' => 'Amapá','Amazonas' => 'Amazonas','Bahia' => 'Bahia','Ceará' => 'Ceará','Distrito Federal' => 'Distrito Federal','Espírito Santo' => 'Espírito Santo','Goiás' => 'Goiás','Maranhão' => 'Maranhão','Mato Grosso' => 'Mato Grosso','Mato Grosso do Sul' => 'Mato Grosso do Sul','Minas Gerais' => 'Minas Gerais','Pará' => 'Pará','Paraíba' => 'Paraíba','Paraná' => 'Paraná','Pernambuco' => 'Pernambuco','Piauí' => 'Piauí','Rio de Janeiro' => 'Rio de Janeiro','Rio Grande do Norte' => 'Rio Grande do Norte','Rio Grande do Sul' => 'Rio Grande do Sul','Rondônia' => 'Rondônia','Roraima' => 'Roraima','Santa Catarina' => 'Santa Catarina','São Paulo' => 'São Paulo','Sergipe' => 'Sergipe','Tocantins' => 'Tocantins'];
			elseif('url' == mb_strtolower($indice, 'UTF-8')):
				$estado = ['acre' => 'Acre','alagoas' => 'Alagoas','amapa' => 'Amapá','amazonas' => 'Amazonas','bahia' => 'Bahia','ceara' => 'Ceará','distrito-federal' => 'Distrito Federal','espirito-santo' => 'Espírito Santo','goias' => 'Goiás','maranhao' => 'Maranhão','mato-grosso' => 'Mato Grosso','mato-grosso-do-sul' => 'Mato Grosso do Sul','minas-gerais' => 'Minas Gerais','para' => 'Pará','paraiba' => 'Paraíba','parana' => 'Paraná','pernambuco' => 'Pernambuco','piaui' => 'Piauí','rio-de-janeiro' => 'Rio de Janeiro','rio-grande-do-norte' => 'Rio Grande do Norte','rio-grande-do-sul' => 'Rio Grande do Sul','rondonia' => 'Rondônia','roraima' => 'Roraima','santa-catarina' => 'Santa Catarina','sao-paulo' => 'São Paulo','sergipe' => 'Sergipe','tocantins' => 'Tocantins'];
			endif;
            $this->add($estado);
            return $this;
        }
        public function uf($indice = 'UF'){
            
			$estado = ['AC' => 'AC','AL' => 'AL','AP' => 'AP','AM' => 'AM','BA' => 'BA','CE' => 'CE','DF' => 'DF','ES' => 'ES','GO' => 'GO','MA' => 'MA','MT' => 'MT','MS' => 'MS','MG' => 'MG','PA' => 'PA','PB' => 'PB','PR' => 'PR','PE' => 'PE','PI' => 'PI','RJ' => 'RJ','RN' => 'RN','RS' => 'RS','RO' => 'RO','RR' => 'RR','SC' => 'SC','SP' => 'SP','SE' => 'SE','TO' => 'TO'];
			if('nome' == mb_strtolower($indice, 'UTF-8')):
				$estado = ['Acre' => 'AC','Alagoas' => 'AL','Amapá' => 'AP','Amazonas' => 'AM','Bahia' => 'BA','Ceará' => 'CE','Distrito Federal' => 'DF','Espírito Santo' => 'ES','Goiás' => 'GO','Maranhão' => 'MA','Mato Grosso' => 'MT','Mato Grosso do Sul' => 'MS','Minas Gerais' => 'MG','Pará' => 'PA','Paraíba' => 'PB','Paraná' => 'PR','Pernambuco' => 'PE','Piauí' => 'PI','Rio de Janeiro' => 'RJ','Rio Grande do Norte' => 'RN','Rio Grande do Sul' => 'RS','Rondônia' => 'RO','Roraima' => 'RR','Santa Catarina' => 'SC','São Paulo' => 'SP','Sergipe' => 'SE','Tocantins' => 'TO'];
			elseif('url' == mb_strtolower($indice, 'UTF-8')):
				$estado = ['acre' => 'AC','alagoas' => 'AL','amapa' => 'AP','amazonas' => 'AM','bahia' => 'BA','ceara' => 'CE','distrito-federal' => 'DF','espirito-santo' => 'ES','goias' => 'GO','maranhao' => 'MA','mato-grosso' => 'MT','mato-grosso-do-sul' => 'MS','minas-gerais' => 'MG','para' => 'PA','paraiba' => 'PB','parana' => 'PR','pernambuco' => 'PE','piaui' => 'PI','rio-de-janeiro' => 'RJ','rio-grande-do-norte' => 'RN','rio-grande-do-sul' => 'RS','rondonia' => 'RO','roraima' => 'RR','santa-catarina' => 'SC','sao-paulo' => 'SP','sergipe' => 'SE','tocantins' => 'TO'];
			endif;
            $this->add($estado);
            return $this;
        }
		public function status(){
            $this->add([1 => 'Ativo', 2 => 'Inativo']);
            return $this;
		}
        public function mes(){
            $this->add(['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro']);
            return $this;
        }
        public function semana(){
            $this->add(['Domingo', 'Segunda-Feira', 'Terça-Feira', 'Quarta-Feira', 'Quinta-Feira', 'Sexta-Feira', 'Sábado']);
            return $this;
        }
    }