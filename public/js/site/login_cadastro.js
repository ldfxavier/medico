$(function(){function e(){document.getElementById("logradouro").value="",document.getElementById("bairro").value="",document.getElementById("cidade").value="",document.getElementById("estado").value=""}document.getElementById("cep").addEventListener("blur",function(a){var o;""!=(o=a.target.value.replace(/\D/g,""))?/^[0-9]{8}$/.test(o)?($("#logradouro").val("..."),$("#bairro").val("..."),$("#cidade").val("..."),$("#estado").val("..."),$("#ibge").val("..."),$.getJSON("https://viacep.com.br/ws/"+o+"/json/?callback=?",function(a){"erro"in a?(e(),Alerta.mensagem("Erro","Formato de CEP inválido.")):($("#logradouro").val(a.logradouro),$("#bairro").val(a.bairro),$("#cidade").val(a.localidade),$("#estado").val(a.uf),$("#ibge").val(a.ibge))})):(e(),Alerta.mensagem("Erro","Formato de CEP inválido.")):e()},!0)});