<?php
	namespace Tdd\Mysql;
	use \Tdd\TDD;
	
	final class Usuario_Equipe extends TDD {
		public function __construct(){
			parent::__construct(TABELA['usuario_equipe']);
		}

		public function validar(): Array {
			// tipo, tamanho, obrigatorio, validar, download, nome
			$this->validar_campo_tabela([
				'id' => ['int', 11, true, [], true, 'ID'],
				'uuid' => ['char', 36, true, [], true, 'Código']
			]);
			return $this->mensagem;
		}
	}