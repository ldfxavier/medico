$(function(){$(document).ready(function(){$('#form_nova_senha input[type="password"]').val("")}),$(".form .bloco__label.icone-ver i.icone").on("click",function(){$("#form_nova_senha input[name=senha_nova], #form_nova_senha input[name=senha_nova_repetir]").attr("type","text"),$(".icone-ver i.visivel").show(),$(this).hide()}),$(".form .bloco__label.icone-ver i.visivel").on("click",function(){$("#form_nova_senha input[name=senha_nova], #form_nova_senha input[name=senha_nova_repetir]").attr("type","password"),$(".icone-ver i.icone").show(),$(this).hide()}),$("body").on("keyup",".elemento--formulario",function(){var e=$("#form_nova_senha input[name=senha_nova]").val(),a=$("#form_nova_senha input[name=senha_nova_repetir]").val();""!=e&&e==a?($(".icone-certo i").addClass("correto"),$(".icone-certo i").removeClass("icone")):($(".icone-certo i").removeClass("correto"),$(".icone-certo i").addClass("icone"))}),$("#form_nova_senha button").click(function(e){e.preventDefault();let a=$("#form_nova_senha"),n=$("input[name=senha_atual]",a).val(),o=$("input[name=senha_nova]",a).val(),r=$("input[name=senha_nova_repetir]",a).val();Loading.show(),$.post(a.attr("action"),{ajax:!0,senha_atual:n,senha_nova:o,senha_nova_repetir:r},function(e){!1===e.erro&&Alerta.mensagem("Senha alterada!","Sua senha foi alterada com sucesso.").recarregar()},"json").fail(function(e){!0===(e=JSON.parse(e.responseText)).erro?Alerta.mensagem(e.titulo,e.texto):Alerta.mensagem("Ocorreu um erro!","Ocorreu um erro ao mudar sua senha, por favor, recarregue a página e tente novamente.")}).always(function(){Loading.hide()})})});