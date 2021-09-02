<h1>PHP</h1>
<div class="margin_20"></div>
<p>Regras para utilização do PHP, na criação de funções, classes, métodos e afins.</p>

<ul>
	<li>Sempre que usar o "use", fazer em uma linha (use \App\Helpers\{Converter, Validar});</li>
	<li>Sempre deve ser dado preferência para criação de helpers;</li>
	<li>Usar snake_case para as variáveis e métodos;</li>
	<li>Usar camelCase para declarar variáveis models e começar com letra maiuscula e terminar com Model ($UsuarioClienteModel = new UsuarioClienteModel);</li>
	<li>Usar camelCase para declarar variáveis helpers e começar com letra maiuscula ($Converter = new Converter);</li>
</ul>

<div class="margin_40"></div>
<h2>CONTROLLER</h2>
<p>A estrutura dos controllers devem seguir a seguinte norma:</p>
<ul>
	<li>Sempre colocar os controllers como "final";</li>
	<li>Usar o Controller apenas para fazer a ligação do Model com o View;</li>
	<li>Sempre que buscar algo no Model, validar se achou resultado no Controller;</li>
	<li>Escrever os métodos privados sempre no final da classe;</li>
	<li>Cada método deve fazer apenas 1 coisa;</li>
	<li>Cada método deve tentar ter no máximo 20 linhas;</li>
	<li>Sempre que fizer uma requisição post, get, put ou delete, comoçar o action com a requisição (post_salvar_dados());</li>
</ul>

<h3>Exemplo:</h3>
<pre>
namespace App\Controllers;
use App\Models\UsuarioCliente;
final class contato extends \System\Controller {

	public function index(){
		$busca = $this->par('busca');

		$UsuarioClienteModel = new UsuarioCliente();
		$lista_usuario = $UsuarioClienteModel->buscar_lista_usuario_ativo($busca);
		
		if(!$lista_usuario):
			return $this->erro();
		endif;
		
		$dado['lista'] = $lista_usuario;
		$dado['busca'] = $busca;

		return $this->view('usuario', $dado);
	}
}
</pre>

<div class="margin_40"></div>
<h2>MODEL</h2>
<p>A estrutura dos models devem seguir a seguinte norma:</p>
<ul>
	<li>Sempre colocar os models como "final";</li>
	<li>Escrever os métodos privados sempre no final da classe;</li>
	<li>Cada método deve fazer apenas 1 coisa;</li>
	<li>Cada método deve tentar ter no máximo 20 linhas;</li>
</ul>

<h3>Exemplo:</h3>
<pre>
namespace App\Models;
final class UsuarioCliente extends \System\Model {

	public function __construct(){
		parent::__construct('nome_da_tabela');
	}

	public function buscar_lista_usuario_ativo(String $tipo): Array {
		return $this->query("...")->where("...")->get();
	}
}
</pre>