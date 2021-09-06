$(function() {
  var PAINEL = $("#PAINEL").val();
  var LINK = $("#LINK").val();
  var ARQUIVO = $("#ARQUIVO").val();
  var EQUIPE_NOME = $("#EQUIPE_NOME").val();
  var SISTEMA = $("#SISTEMA").val();

  $.pagina({
    botao: ".but_bloco_ajax",
    attr: "data-href",
    fechar: false
  });
  $.pagina({
    botao: ".but_bloqueado_ajax",
    attr: "data-href",
    fechar_mascara: false,
    fechar_tecla: false,
    fechar_botao: ".but_fechar_ajax",
    fechar: false
  });

  $("body").on("click", ".but_fechar_ajax", function() {
    $("#plugins_pagina").click();
    return false;
  });
  $("body").on("click", "#plugins_pagina header i.fechar", function() {
    $("#plugins_pagina").click();
  });

  $.textarea({
    id: ".textarea_editor_normal",
    height: 350,
    barra: "normal"
  });

  $.textarea({
    id: ".textarea_editor_completa",
    height: 350,
    barra: "completa"
  });
  $.textarea({
    id: ".textarea_editor_tabela",
    height: 350,
    barra: "tabela"
  });

  /**
   * SISTEMA DE GRAFICO
   **/
  if ($(".grafico_tabela").length > 0) {
    var quantidade;
    var grafico_width;
    $(".grafico_tabela").each(function() {
      quantidade = $(".topo .td", this).length - 1;
      $(".direita .td", this).css("width", "calc(100% / " + quantidade + ")");
    });
  }
  $("body").on("click", ".bloco_grafico_erro i", function() {
    $(this)
      .closest(".bloco_grafico_erro")
      .remove();
  });

  /**
   * SISTEMA DE ATUALIZAÇÃO
   **/
  $("body").on("change", ".but_change_atualizar", function() {
    var id = $(this).attr("data-id");
    var cod = $(this).attr("data-cod") || "";
    var app = $(this).attr("data-app");
    var historico = $(this).attr("data-historico") || "";
    var nome =
      $(this).attr("name") ||
      $(this).attr("data-name") ||
      $("*[name]", this).attr("name");
    var valor = $(this).val() || $("*[name]", this).val();

    if(valor == undefined){
      valor = '';
    }

    if (SISTEMA == "producao") {
      $.loading("show");
    }
    $.post(
      PAINEL + "/post-atualizar-unico",
      {
        id: id,
        app: app,
        nome: nome,
        valor: valor
      },
      function() {
        if (cod != "") {
          $("#but_historico_reload").attr({
            "data-app": app,
            "data-cod": cod,
            "data-volta": PAINEL + "/app/" + app
          });
          $("#but_historico_reload").click();
        }
        $.alerta({ notificacao: "Atualização realizada." });
        $.loading("hide");
        if (historico == 1)
          historico_add(app, cod, "", "", undefined, 6, false);
      }
    );
  });

  /**
   * ABRIR E FECHAR BLOCOS
   **/
  $(".abrir_fechar .but_abrir").click(function(e) {
    var bloco = $(this).closest(".abrir_fechar");
    if (bloco.hasClass("aberto")) bloco.removeClass("aberto");
    else bloco.addClass("aberto");
  });

  /**
   * BLOCO PARA ARQUIVOS
   **/
  $(".bloco_arquivo_lista").on("focus", ".lista input", function() {
    $(this)
      .closest("li.arquivo")
      .addClass("hover");
  });
  $(".bloco_arquivo_lista").on("blur", ".lista input", function() {
    $(this)
      .closest("li.arquivo")
      .removeClass("hover");
  });
  $(".bloco_arquivo_lista").on("change", ".lista input", function() {
    var bloco = $(this).closest("li");
    var valor = $(this).val();
    $(".nome", bloco).text(valor);
  });

  var bloco_arquivo_lista_deletar;
  var bloco_arquivo_lista_deletar_li;
  $(".bloco_arquivo_lista").on(
    "click",
    "li.arquivo .but_arquivo_deletar",
    function() {
      bloco_arquivo_lista_deletar = $(this).closest(".bloco_arquivo_lista");
      bloco_arquivo_lista_deletar_li = $(this).closest("li.arquivo");
      $.alerta({
        titulo: "Deletar arquivo!",
        texto: "Você tem certeza que quer deletar esse arquivo?",
        confirmar: "but_arquivo_deletar"
      });
    }
  );
  $("body").on("click", "#but_arquivo_deletar", function() {
    var bloco = bloco_arquivo_lista_deletar;
    var li = bloco_arquivo_lista_deletar_li;
    var app = $("input", li).attr("data-app");
    var id = $("input", li).attr("data-id");
    var dados = [id];

    $.post(
      PAINEL + "/post-deletar",
      {
        app: app,
        dados: dados
      },
      function() {
        li.remove();
        $.alerta({ notificacao: "Registro deletado com sucesso!" });
        if ($("li.arquivo", bloco).size() == 0)
          $(".lista", bloco).html(
            '<li class="zero">SEM ARQUIVOS NO MOMENTO</li>'
          );
      }
    );
  });

  var upload_arquivo_lista = function(resposta, bloco) {
    if (resposta.erro == true) {
      $.alerta({
        titulo: resposta.titulo,
        texto: resposta.texto
      });
    } else if (resposta.erro == false) {
      if ($(".lista li.zero", bloco).size() > 0)
        $(".lista li.zero", bloco).remove();
      $(".lista", bloco).append(
        '<li class="arquivo" style="background-image: url(' +
          LINK +
          '/images/ext/file.png)"><a class="download" download="' +
          resposta.arquivo +
          '" href="' +
          resposta.link +
          '"><i data-font="&#xf0ed;"></i></a><a class="deletar but_arquivo_deletar" data-id="' +
          resposta.id +
          '" href="#deletar"><i data-font="&#xe808;"></i></a><input type="text" data-name="titulo" class="but_change_atualizar" data-id="' +
          resposta.id +
          '" data-app="arquivo" placeholder="Nome do arquivo" value="' +
          resposta.titulo +
          '"><div class="nome">' +
          resposta.titulo +
          "</div></li>"
      );
    }
    $(".botao input", bloco).val("");
    $.loading("hide");
  };
  $(".bloco_arquivo_lista .botao input").change(function() {
    var bloco = $(this).closest(".bloco_arquivo_lista");
    var diretorio = bloco.attr("data-diretorio");
    var local = bloco.attr("data-local");
    var ext = bloco.attr("data-ext");
    var cod = bloco.attr("data-cod");

    var dados = new FormData();
    dados.append("arquivo", $(this).prop("files")[0]);
    dados.append("diretorio", diretorio);
    dados.append("local", local);
    dados.append("ext", ext);
    dados.append("cod", cod);

    if (SISTEMA == "producao") {
      $.loading("show");
    }
    $.ajax({
      url: PAINEL + "/post-upload-arquivo",
      data: dados,
      type: "post",
      dataType: "json",
      success: function(resposta) {
        upload_arquivo_lista(resposta, bloco);
      },
      error: function(resposta) {
        upload_arquivo_lista(resposta, bloco);
      },
      processData: false,
      cache: false,
      contentType: false
    });
  });

  /**
   * UPLOAD DE ARQUIVO SIMPLES
   **/
  var upload_arquivo = function(resposta, bloco) {
    if (resposta.erro == true) {
      $.alerta({
        titulo: resposta.titulo,
        texto: resposta.texto
      });
    } else if (resposta.erro == false) {
      $(".lista", bloco).removeClass("hide");
      $(".lista a.download").attr("href", resposta.link);
      $(".lista input", bloco).val(resposta.arquivo);
    }
    $(".botao input", bloco).val("");
    $.loading("hide");
  };
  $(".bloco_arquivo .botao input").change(function() {
    var bloco = $(this).closest(".bloco_arquivo");
    var diretorio = bloco.attr("data-diretorio");
    var ext = bloco.attr("data-ext");

    var dados = new FormData();
    dados.append("arquivo", $(this).prop("files")[0]);
    dados.append("diretorio", diretorio);
    dados.append("ext", ext);

    if (SISTEMA == "producao") {
      $.loading("show");
    }
    $.ajax({
      url: PAINEL + "/post-upload-arquivo-simples",
      data: dados,
      type: "post",
      dataType: "json",
      success: function(resposta) {
        upload_arquivo(resposta, bloco);
      },
      error: function(resposta) {
        upload_arquivo(resposta, bloco);
      },
      processData: false,
      cache: false,
      contentType: false
    });
  });
  $(".bloco_arquivo .lista a.deletar").click(function() {
    var bloco = $(this).closest(".bloco_arquivo");
    $(".lista input", bloco).val("");
    $(".lista", bloco).addClass("hide");
  });

  /**
   * BLOCO DE IMAGENS
   **/
  var upload_imagem = function(resposta, bloco, retorno) {
    if (resposta.erro == true) {
      $.alerta({
        titulo: resposta.titulo,
        texto: resposta.texto
      });
    } else if (resposta.erro == false) {
      if (retorno == "img") {
        $("figure", bloco).html('<img src="' + resposta.link + '" >');
      } else if (retorno == "css") {
        $("figure", bloco).css(
          "background-image",
          "url(" + resposta.link + ")"
        );
      }
      bloco.addClass("ativo");
      $("input.input_imagem", bloco).val(resposta.arquivo);
    }
    $("input[type=file]", bloco).val("");
    $.loading("hide");
  };
  $("body").on("change", ".bloco_imagem input", function() {
    var bloco = $(this).closest(".bloco_imagem");
    var diretorio = bloco.attr("data-diretorio") || "";
    var ext = bloco.attr("data-ext") || "";
    var width = bloco.attr("data-width") || "";
    var height = bloco.attr("data-height") || "";
    var tipo = bloco.attr("data-tipo") || "";
    var retorno = bloco.attr("data-retorno") || "img";

    var dados = new FormData();
    dados.append("imagem", $(this).prop("files")[0]);
    dados.append("diretorio", diretorio);
    dados.append("ext", ext);
    dados.append("width", width);
    dados.append("height", height);
    dados.append("tipo", tipo);

    if (SISTEMA == "producao") {
      $.loading("show");
    }
    $.ajax({
      url: PAINEL + "/post-upload-imagem",
      data: dados,
      type: "post",
      dataType: "json",
      success: function(resposta) {
        upload_imagem(resposta, bloco, retorno);
      },
      error: function(resposta) {
        upload_imagem(resposta, bloco, retorno);
      },
      processData: false,
      cache: false,
      contentType: false
    });
  });
  var bloco_imagem_geral;
  $("body").on("click", ".bloco_imagem i.fechar", function() {
    bloco_imagem_geral = $(this).closest(".bloco_imagem");
    $.alerta({
      titulo: "Confirmar remoção!",
      texto: "Deseja remover essa imagem? Essa ação não poderá ser desfeita.",
      confirmar: "but_imagem_geral_remover"
    });
  });
  $("body").on("click", "#but_imagem_geral_remover", function() {
    var bloco = bloco_imagem_geral;
    var retorno = $(bloco).attr("data-retorno");
    $(".input_imagem", bloco).val("");
    if (retorno == "img") {
      $("figure", bloco).html("");
      bloco.removeClass("ativo");
    } else if (retorno == "css") {
      $("figure", bloco).css("background-image", "url()");
      bloco.removeClass("ativo");
    }
    return false;
  });

  /**
   * BLOCO DE LISTA DE IMAGENS
   **/
  var upload_imagem_lista = function(resposta, bloco, retorno) {
    if (resposta.erro == true) {
      $.alerta({
        titulo: resposta.titulo,
        texto: resposta.texto
      });
    } else if (resposta.erro == false) {
      $(".zero_geral", bloco).remove();
      if (retorno == "img") {
        $(".bloco_imagem_lista_conteudo", bloco).append(
          '<figure data-id="' +
            resposta.id +
            '"><img src="' +
            resposta.link +
            '" /><i class="fechar" data-font="&#xe813;" data-ajuda="Remover imagem" data-id="' +
            resposta.id +
            '"></i><input type="text" placeholder="Nome da imagem" /></figure>'
        );
      } else if (retorno == "css") {
        $(".bloco_imagem_lista_conteudo", bloco).append(
          '<figure style="background-image: url(' +
            resposta.link +
            ')" data-id="' +
            resposta.id +
            '"><i class="fechar" data-font="&#xe813;" data-ajuda="Remover imagem"></i><input type="text" placeholder="Nome da imagem" /></figure>'
        );
      }
    }
    $("input[type=file]", bloco).val("");
    $.loading("hide");
  };
  $("body").on("change", ".bloco_imagem_lista input", function() {
    var bloco = $(this).closest(".bloco_imagem_lista");
    var diretorio = bloco.attr("data-diretorio") || "";
    var ext = bloco.attr("data-ext") || "";
    var width = bloco.attr("data-width") || "";
    var height = bloco.attr("data-height") || "";
    var tipo = bloco.attr("data-tipo") || "";
    var retorno = bloco.attr("data-retorno") || "img";
    var cod = bloco.attr("data-cod");
    var app = bloco.attr("data-app");

    var dados = new FormData();
    dados.append("imagem", $(this).prop("files")[0]);
    dados.append("diretorio", diretorio);
    dados.append("ext", ext);
    dados.append("width", width);
    dados.append("height", height);
    dados.append("tipo", tipo);
    dados.append("cod", cod);
    dados.append("app", app);

    if (SISTEMA == "producao") {
      $.loading("show");
    }
    $.ajax({
      url: PAINEL + "/post-upload-imagem-lista",
      data: dados,
      type: "post",
      dataType: "json",
      success: function(resposta) {
        upload_imagem_lista(resposta, bloco, retorno);
      },
      error: function(resposta) {
        upload_imagem_lista(resposta, bloco, retorno);
      },
      processData: false,
      cache: false,
      contentType: false
    });
  });
  var bloco_imagem_geral_lista;
  $("body").on("click", ".bloco_imagem_lista i.fechar", function() {
    bloco_imagem_geral_lista = $(this).closest("figure");
    $.alerta({
      titulo: "Confirmar remoção!",
      texto: "Deseja remover essa imagem? Essa ação não poderá ser desfeita.",
      confirmar: "but_imagem_lista_remover"
    });
  });
  $("body").on("click", "#but_imagem_lista_remover", function() {
    var bloco = bloco_imagem_geral_lista;
    var bloco_imagem = bloco.closest(".bloco_imagem_lista_conteudo");
    var id = bloco.attr("data-id");
    $.post(
      PAINEL + "/post-upload-imagem-lista-deletar",
      { id: id },
      function(resposta) {
        if (resposta.erro == false) {
          bloco.remove();
          $.alerta({ notificacao: "Imagem deletada com sucesso." });
          if ($("figure", bloco_imagem).size() == 0)
            bloco_imagem.html(
              '<div class="zero_geral">SEM IMAGENS ENVIADAS ATÉ O MOMENTO</div>'
            );
        } else {
          $.alerta({
            titulo: resposta.titulo,
            texto: resposta.texto
          });
        }
      },
      "json"
    );
    return false;
  });

  /**
   * BLOCO TAG INPUT
   **/
  var tag_add = function(bloco) {
    var valor = $(".bloco_tag_input_botao .bloco_tag_input_input", bloco).val();
    var nome = bloco.attr("data-nome");

    if (valor != "") {
      $(".bloco_tag_input_botao .bloco_tag_input_input", bloco).val("");
      $(".bloco_tag_input_botao_ul", bloco).append(
        '<li class="bloco_tag_input_li"><span class="bloco_tag_input_span">' +
          valor +
          '</span><input type="hidden"  data-array="1" name="' +
          nome +
          '" value="' +
          valor +
          '"><i class="bloco_tag_input_deletar" data-ajuda="De 2 cliques para apagar" data-font="&#xe813;"></i></li>'
      );
    }
  };
  $("body").on(
    "dblclick",
    ".bloco_tag_input .bloco_tag_input_deletar",
    function() {
      $("#plugins_ajuda").remove();
      $(this)
        .closest(".bloco_tag_input_li")
        .remove();
    }
  );
  $("body").on("click", ".bloco_tag_input .bloco_tag_input_add", function() {
    tag_add($(this).closest(".bloco_tag_input"));
  });
  $("body").on(
    "keyup",
    ".bloco_tag_input .bloco_tag_input_botao .bloco_tag_input_input",
    function(e) {
      if (e.keyCode == 13) {
        tag_add($(this).closest(".bloco_tag_input"));
      }
    }
  );

  /**
   * BLOCO LISTA INPUT
   **/
  // Buscar
  var bloco_lista_input_busca = function(bloco) {
    var valor = $(".bloco_lista_input_input", bloco).val();
    var nome = $(".bloco_lista_input_input", bloco).attr("name");
    var link = bloco.attr("data-busca");
    if (valor == "") {
      $.alerta({
        titulo: "Campo obrigatório!",
        texto: "Digite algo antes de continuar."
      });
      return false;
    }
    if (link != "") {
      $.post(
        link,
        { busca: valor },
        function(resposta) {
          if (resposta.erro == false) {
            $(".bloco_lista_input_input", bloco).val("");
            $(".bloco_lista_input_ul", bloco).append(resposta.li);
            $(".bloco_lista_input_ul .bloco_lista_input_zero", bloco).remove();
          } else if (resposta.erro == true) {
            $.alerta({
              titulo: resposta.titulo,
              texto: resposta.texto
            });
          }
        },
        "json"
      );
    } else {
      $(".bloco_lista_input_input", bloco).val("");
      $(".bloco_lista_input_ul", bloco).append(
        '<li class="bloco_lista_input_li"><input type="hidden" name="' +
          nome +
          '" data-array="1" value="' +
          valor +
          '"><div class="bloco_lista_input_nome">' +
          valor +
          '</div><i class="bloco_lista_input_remover" data-ajuda="Remover da lista" data-font="&#xe813;"></i></li>'
      );
    }
  };
  $(".bloco_lista_input .bloco_lista_input_botao").click(function() {
    var bloco = $(this).closest(".bloco_lista_input");
    bloco_lista_input_busca(bloco);
    return false;
  });
  $(".bloco_lista_input .bloco_lista_input_input").keyup(function(e) {
    if (e.keyCode == 13) {
      var bloco = $(this).closest(".bloco_lista_input");
      bloco_lista_input_busca(bloco);
    }
    return false;
  });

  // Remover
  var bloco_lista_input_remove_bloco;
  var bloco_lista_input_remove_li;
  $(".bloco_lista_input").on("click", ".bloco_lista_input_remover", function() {
    bloco_lista_input_remove_bloco = $(this).closest(".bloco_lista_input");
    bloco_lista_input_remove_li = $(this).closest(".bloco_lista_input_li");
    $.alerta({
      titulo: "Deseja remover?",
      texto: "Cuidado, essa ação não poderá ser desfeita.",
      confirmar: "but_lista_input_remover"
    });
    return false;
  });
  $("body").on("click", "#but_lista_input_remover", function() {
    bloco_lista_input_remove_li.remove();
    if (
      $(".bloco_lista_input_li", bloco_lista_input_remove_bloco).length == 0
    ) {
      $(".bloco_lista_input_ul", bloco_lista_input_remove_bloco).html(
        '<li class="bloco_lista_input_zero">SEM USUÁRIO VINCULADO</li>'
      );
    }
    return false;
  });

  /**
   * BLOCO DE VÍDEO
   **/
  $("body").on("focus", ".bloco_video input", function() {
    $(this)
      .closest(".bloco_video")
      .addClass("hover");
  });
  $("body").on("blur", ".bloco_video input", function() {
    $(this)
      .closest(".bloco_video")
      .removeClass("hover");
  });
  $("body").on("change", ".bloco_video input", function() {
    var valor = $(this).val();
    var bloco = $(this).closest(".bloco_video");
    var explode;
    if (valor.indexOf("youtube.com") != -1) {
      explode = valor.split("v=");
      $(".responsivo", bloco).html(
        '<iframe src="https://www.youtube.com/embed/' +
          explode[explode.length - 1] +
          '?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>'
      );
      bloco.addClass("ativo");
    } else if (valor.indexOf("vimeo.com") != -1) {
      explode = valor.split("/");
      $(".responsivo", bloco).html(
        '<iframe src="https://player.vimeo.com/video/' +
          explode[explode.length - 1] +
          '?title=0&byline=0&portrait=0" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>'
      );
      bloco.addClass("ativo");
    } else {
      $(".responsivo", bloco).html("");
      $(this).val("");
      bloco.removeClass("ativo");
    }
  });

  /**
   * FORÇA A MUDANÇA DE SENHA
   **/
  if ($("#but_forca_mudar_senha").size() == 1) {
    $("#bloco_senha")
      .show()
      .stop()
      .animate({ opacity: 0 }, 0)
      .animate({ opacity: 1 }, 300);
    //$('#but_forca_mudar_senha').removeAttr('id');
    $.post(PAINEL + "/post_mudar_senha");
  }

  /**
   * SISTEMA DE HISTÓRICO
   **/
  // Funcao para abrir histórico obrigatorio
  $("#but_historico_reload").click(function() {
    var app = $(this).attr("data-app");
    var cod = $(this).attr("data-cod");
    var volta = $(this).attr("data-volta");

    historico_add(app, cod, "", "", volta, 5, true);
  });
  // Função para abrir o histórico
  var historico_add = function(app, cod, bloco, booleano, volta, tipo, fechar) {
    $("body").css("overflow-y", "hidden");

    $("#bloco_historico_add")
      .css("display", "flex")
      .stop()
      .animate({ opacity: 0 }, 0)
      .animate({ opacity: 1 }, 300);

    if (fechar == undefined) {
      $("#bloco_historico_add header i.fechar").show();
    } else {
      $("#bloco_historico_add header i.fechar").hide();
    }

    if (booleano == undefined || booleano == "") {
      $("#bloco_historico_add .historico_booleano").hide();
    } else {
      $(
        "#bloco_historico_add .historico_booleano .historico_booleano_texto"
      ).html(booleano);
      $("#bloco_historico_add .historico_booleano").css("display", "flex");
    }

    var historico_app = $("#historico_input_app").val() || app;
    var historico_cod = $("#historico_input_cod").val() || cod;

    if (historico_app != undefined)
      $("#bloco_historico_add input[name=app]").val(historico_app);
    if (historico_cod != undefined)
      $("#bloco_historico_add input[name=cod]").val(historico_cod);
    if (bloco != undefined)
      $("#bloco_historico_add input[name=bloco]").val(bloco);
    if (volta != undefined)
      $("#bloco_historico_add input[name=volta]").val(volta);
    if (tipo != undefined) {
      $("#bloco_historico_add select[name=tipo]").val(tipo);
      $("#bloco_historico_add .tipo li").removeClass("hover");
      $("#bloco_historico_add .tipo li[data-tipo=" + tipo + "]").addClass(
        "hover"
      );
    }
  };

  // Função para fechar o histórico
  var historico_fechar = function(acao) {
    $("body").css("overflow-y", "auto");

    var tipo = $("#bloco_historico_add select[name=tipo]").val();
    var bloco = $("#bloco_historico_add input[name=bloco]").val();
    var volta = $("#bloco_historico_add input[name=volta]").val();
    var texto = $("#bloco_historico_add textarea[name=texto]").val();

    if ($("#bloco_historico_add input[name=booleano]").length == 1) {
      $("#bloco_historico_add input[name=booleano]").removeAttr("checked");
    }

    var icone = "";
    if (tipo == 1 || tipo == 2) {
      icone = "telefone";
    } else if (tipo == 3 || tipo == 4) {
      icone = "email";
    } else if (tipo == 5) {
      icone = "editar";
    } else if (tipo == 6) {
      icone = "outro";
    }
    if (acao == true && bloco != "" && $("#" + bloco).size() == 1) {
      if ($("#" + bloco + " li.zero").size() > 0)
        $("#" + bloco + " li.zero").remove();
      $("#" + bloco).prepend(
        '<li class="lista"><i class="' +
          icone +
          '"></i><div class="dados_lista"><span class="nome">' +
          EQUIPE_NOME +
          '</span> <span class="data">Agora</span><p>' +
          texto +
          "</p></div></li>"
      );
      $.loading("hide");
    } else if (volta != "") {
      window.location.assign(volta);
    }

    $.loading("hide");

    $("#bloco_historico_add")
      .stop()
      .animate({ opacity: 0 }, 300, function() {
        $("#bloco_historico_add .tipo li").removeClass("hover");
        $("#bloco_historico_add .tipo li:first").addClass("hover");
        $("#bloco_historico_add select[name=tipo]").val(1);
        $("#bloco_historico_add textarea[name=texto]").val("");
        $("#bloco_historico_add input[name=app]").val("");
        $("#bloco_historico_add input[name=cod]").val("");
        $("#bloco_historico_add input[name=bloco]").val("");
        $("#bloco_historico_add input[name=volta]").val("");
        $(this).hide();
      });
  };

  // Botão para abrir histórico
  $(".but_add_historico").click(function() {
    var app = $(this).attr("data-app");
    var cod = $(this).attr("data-cod");
    var booleano = $(this).attr("data-booleano");
    var bloco = $(this).attr("data-bloco");

    historico_add(app, cod, bloco, booleano);
    return false;
  });
  // Botão para fechar histórico
  $("#bloco_historico_add header i.fechar").click(function() {
    historico_fechar();
    return false;
  });

  // Muda o tipo do histórico
  $("#bloco_historico_add .tipo li").click(function() {
    var valor = $(this).attr("data-tipo");
    $("#bloco_historico_add .tipo li").removeClass("hover");
    $(this).addClass("hover");
    $("#bloco_historico_add select[name=tipo]").val(valor);
  });

  // Salva o histórico
  $("body").on("click", "#bloco_historico_add button", function() {
    var link = $("#bloco_historico_add form").attr("action");

    var app = $("#bloco_historico_add input[name=app]").val() || "";
    var cod = $("#bloco_historico_add input[name=cod]").val() || "";
    var tipo = $("#bloco_historico_add select[name=tipo]").val() || "";
    var texto = $("#bloco_historico_add textarea[name=texto]").val() || "";
    var booleano =
      $(
        "#bloco_historico_add input[type=checkbox][name=booleano]:checked"
      ).val() || "";

    if (SISTEMA == "producao") {
      $.loading("show");
    }
    $.post(
      link,
      {
        app: app,
        cod: cod,
        tipo: tipo,
        booleano: booleano,
        texto: texto
      },
      function(resposta) {
        if (resposta.erro == false) {
          $.alerta({ notificacao: "Histórico salvo com sucesso." });
          historico_fechar(true);
        } else if (resposta.erro == true) {
          $.alerta({ notificacao: resposta.texto });
          $.loading("hide");
        } else {
          $.alerta({
            notificacao: "Erro ao salvar, por favor, repotar a equipe técnica."
          });
          $.loading("hide");
        }
      },
      "json"
    );
    return false;
  });

  // Abrir histórico completo
  var historico_lista_fechar = function() {
    $("#bloco_historico_abrir")
      .stop()
      .animate({ opacity: 0 }, 300, function() {
        $(this).hide();
        $("#bloco_historico_abrir ul").html(
          '<li class="loading">CARREGANDO HISTÓRICO</li>'
        );
        $("body").css("overflow-y", "auto");
      });
  };
  var historico_pagina = 1;
  var historico_quantidade = 1;
  var historico_app;
  var historico_cod;
  $(".but_visualizar_historico").click(function() {
    var cod = $(this).attr("data-cod");
    var app = $(this).attr("data-app");
    historico_pagina = 1;
    historico_quantidade = 1;
    historico_app = app;
    historico_cod = cod;

    $("#but_historico_next").hide();
    $("#but_historico_prev").hide();
    $("body").css("overflow-y", "hidden");

    if (SISTEMA == "producao") {
      $.loading("show");
    }
    $("#bloco_historico_abrir")
      .stop()
      .css("display", "flex")
      .animate({ opacity: 0 }, 0)
      .animate({ opacity: 1 }, 300, function() {
        $("#bloco_historico_abrir ul").html(
          '<li class="loading">CARREGANDO HISTÓRICO</li>'
        );
        $("#bloco_historico_abrir ul").load(
          PAINEL + "/historico_lista",
          {
            pagina: historico_pagina,
            cod: cod,
            app: app
          },
          function(resposta) {
            $.loading("hide");
            historico_quantidade = $(
              "#bloco_historico_abrir ul span:first"
            ).attr("data-pagina");
            if (historico_quantidade > 1) {
              $("#but_historico_next").show();
              $("#but_historico_prev").show();
            }
          }
        );
      });
  });
  $("#bloco_historico_abrir").click(function(e) {
    if ($(e.target).attr("id") == "bloco_historico_abrir")
      historico_lista_fechar();
  });
  $("#bloco_historico_abrir header .fechar").click(function() {
    historico_lista_fechar();
  });

  $("#bloco_historico_abrir #but_historico_next").click(function() {
    if (historico_quantidade > historico_pagina) {
      historico_pagina++;
      if (SISTEMA == "producao") {
        $.loading("show");
      }
      $("#bloco_historico_abrir ul").html(
        '<li class="loading">CARREGANDO HISTÓRICO</li>'
      );
      $("#bloco_historico_abrir ul").load(
        PAINEL + "/historico_lista",
        {
          pagina: historico_pagina,
          cod: historico_cod,
          app: historico_app
        },
        function(resposta) {
          $.loading("hide");
        }
      );
    }
  });
  $("#bloco_historico_abrir #but_historico_prev").click(function() {
    if (historico_pagina > 1) {
      historico_pagina--;
      if (SISTEMA == "producao") {
        $.loading("show");
      }
      $("#bloco_historico_abrir ul").html(
        '<li class="loading">CARREGANDO HISTÓRICO</li>'
      );
      $("#bloco_historico_abrir ul").load(
        PAINEL + "/historico_lista",
        {
          pagina: historico_pagina,
          cod: historico_cod,
          app: historico_app
        },
        function(resposta) {
          $.loading("hide");
        }
      );
    }
  });

  /**
   * SISTEMA DE PEGAR DADOS DE FORMULARIO
   **/
  var form_dados = function(form, falso) {
    var dados = {};
    $("*[name]", form).each(function(i) {
      var nome = $(this).attr("name");

      if ($(this).attr("type") == "checkbox") {
        if (dados[nome] == undefined && !$(this).is(":checked")) {
          dados[nome] = [];
        } else if (dados[nome] == undefined && $(this).is(":checked")) {
          dados[nome] = Array($(this).val());
        } else if ($.isArray(dados[nome]) && $(this).is(":checked")) {
          dados[nome].push($(this).val());
        }
      } else if ($(this).attr("data-array") == "1") {
        if (dados[nome] == undefined) {
          dados[nome] = Array($(this).val());
        } else if ($.isArray(dados[nome])) {
          dados[nome].push($(this).val());
        }
      } else {
        var valor;
        if (falso == true) {
          if ($(this).attr("data-editor") == 1)
            valor = tinyMCE.get(nome).getContent();
          else valor = $(this).val();
          if($(this).attr('data-ckeditor') == 1) valor = CKEDITOR.instances.editor_texto.getData();
          else if($(this).attr('data-ckeditor') == 2) valor = CKEDITOR.instances.editor_texto2.getData();
          else if($(this).attr('data-ckeditor') == 3) valor = CKEDITOR.instances.editor_texto3.getData();
          else valor = $(this).val();
          dados[nome] = valor;
        } else if (false == false && $(this).attr("data-falso") == undefined) {
          if ($(this).attr("data-editor") == 1)
            valor = tinyMCE.get(nome).getContent();
          else valor = $(this).val();
          if($(this).attr('data-ckeditor') == 1) valor = CKEDITOR.instances.editor_texto.getData();
          else if($(this).attr('data-ckeditor') == 2) valor = CKEDITOR.instances.editor_texto2.getData();
          else if($(this).attr('data-ckeditor') == 3) valor = CKEDITOR.instances.editor_texto3.getData();
          else valor = $(this).val();
          dados[nome] = valor;
        }
      }
    });
    return dados;
  };

  /**
   * SISTEMA DE PRE-VISUALIZACAO
   **/
  $("body").on("click", ".but_previsualizacao", function() {
    var form = $("#form_geral");
    var dados = form_dados(form, true);

    if ($("#bloco_previsualizacao").size() > 0)
      $("#bloco_previsualizacao").remove();
    $("body").append(
      '<div id="bloco_previsualizacao"><i class="fechar" id="but_previsualizacao_fechar"></i><div class="conteudo"></div></div>'
    );

    if ($("#plugins_ajuda").size() > 0) $("#plugins_ajuda").remove();

    if (SISTEMA == "producao") {
      $.loading("show");
    }
    $("body").css("overflow-y", "hidden");
    $("#bloco_previsualizacao .conteudo").load(
      PAINEL + "/pre-visualizacao/" + $("#form_app_geral").val(),
      {
        dados: dados
      },
      function() {
        $.loading("hide");
        $("#bloco_previsualizacao")
          .stop()
          .show()
          .animate({ opacity: 0 }, 0)
          .animate({ opacity: 1 }, 300);
      }
    );
  });
  $("body").on(
    "click",
    "#but_previsualizacao_fechar, #bloco_previsualizacao",
    function(e) {
      if (
        $(e.target).attr("id") == "but_previsualizacao_fechar" ||
        $(e.target).attr("id") == "bloco_previsualizacao"
      ) {
        $("body").css("overflow-y", "auto");
        $("#bloco_previsualizacao")
          .stop()
          .animate({ opacity: 0 }, 300, function() {
            $(this).remove();
          });
      }
    }
  );

  /**
   * SISTEMA DE ADD GERAL
   **/
  $("body").on("click", "#but_add_geral", function() {
    var form = $("#form_geral");
    var app = $("#form_app_geral").val();
    var link = form.attr("action");
    var volta = $("#form_volta_geral").val();
    var historico = $(this).attr("data-historico") || 1;
    var booleano = $(this).attr("data-booleano") || "";

    var dados = form_dados(form);

    if (SISTEMA == "producao") {
      $.loading("show");
    }
    $.post(
      link,
      {
        app: app,
        dados: dados
      },
      function(resposta) {
        if (resposta.erro == false) {
          $.loading("hide");

          var mensagem_ok;
          if (dados.id == undefined)
            mensagem_ok = "Dados cadastrado com sucesso.";
          else mensagem_ok = "Dados atualizado com sucesso.";

          if ($("#plugins_pagina").size() == 1) $("#plugins_pagina").click();

          if (historico == 1)
            historico_add(app, dados.cod, "", booleano, volta, 5, true);
          else if (volta != "") window.location.assign(volta);

          $.alerta({ notificacao: mensagem_ok });
        } else if (resposta.erro == true) {
          $.loading("hide");
          $.alerta({ notificacao: resposta.texto });
        } else {
          $.loading("hide");
          $.alerta({
            notificacao: "Erro no envio, por favor, informar suporte."
          });
        }
        $.loading("hide");
      },
      "json"
    );
    return false;
  });

  $("body").on("click", "#but_deletar_form", function() {
    $.alerta({
      titulo: "Confirmar ação!",
      texto: "Deseja deletar esse registro? Essa ação não poderá ser desfeita.",
      confirmar: "but_deletar_form_confirmar"
    });
    return false;
  });
  $("body").on("click", "#but_deletar_form_confirmar", function() {
    var form = $("#but_deletar_form").closest("form");
    var app = $("#form_app_geral").val();
    var id = $("input[name=id]", form).val();
    var dados = [id];

    $.post(
      PAINEL + "/post-deletar",
      {
        app: app,
        dados: dados
      },
      function() {
        $(".ul_lista li.li[data-id=" + id + "]").remove();
        $("#plugins_pagina").click();
        $.alerta({ notificacao: "Registro deletado com sucesso!" });
      }
    );
  });

  /**
   * SISTEMA PARA DELETAR GERAL
   **/
  $(".but_deletar_lista").click(function() {
    $.alerta({
      titulo: "CUIDADO!",
      texto:
        "Você irá deletar os registros selecionados! Essa ação não poderá ser desfeita, tem certeza que deseja continuar?",
      confirmar: "but_deletar_lista"
    });
  });
  $("body").on("click", "#but_deletar_lista", function() {
    var app = $("#bloco_lista_geral").attr("data-app");
    var dados = [];
    $("#bloco_lista_geral li.selecionado").each(function() {
      dados.push($(this).attr("data-id"));
    });

    $.post(
      PAINEL + "/post-deletar",
      {
        app: app,
        dados: dados
      },
      function() {
        $("#bloco_lista_geral li.selecionado").remove();
        if ($("#bloco_lista_geral li.li").size() == 0) {
          $("#bloco_lista_geral").html(
            '<div class="zero"><i data-font="&#xe801;"></i><span>SEM DADOS NO MOMENTO</span></div>'
          );
          $(".but_download_geral").remove();
        }

        $(".but_deletar_lista").addClass("hide");
      }
    );
  });

  /**
   * SISTEMA DE BLOQUEIO
   **/
  $(".bloco_admin span").click(function(e) {
    $(this)
      .closest(".bloco_admin")
      .addClass("bloco_esperando_autorizacao");
    var tipo = $(this).attr("data-admin") || 3;
    if (tipo == 1) {
      $("#bloco_autorizacao input[name=login]").show();
      $("#bloco_autorizacao input[name=login]").focus();
      $("#bloco_autorizacao input[name=login]").attr(
        "placeholder",
        "Login do administrador"
      );
      $(
        "#bloco_autorizacao form .input_password_geral .bloco_password input"
      ).attr("placeholder", "Senha do administrador");
    } else if (tipo == 2) {
      $("#bloco_autorizacao input[name=login]").show();
      $("#bloco_autorizacao input[name=login]").focus();
      $("#bloco_autorizacao input[name=login]").attr(
        "placeholder",
        "Login do gerente"
      );
      $(
        "#bloco_autorizacao form .input_password_geral .bloco_password input"
      ).attr("placeholder", "Senha do gerente");
    } else if (tipo == 3) {
      $("#bloco_autorizacao input[name=login]").hide();
      $("#bloco_autorizacao input[name=password]").focus();
      $(
        "#bloco_autorizacao form .input_password_geral .bloco_password input"
      ).attr("placeholder", "Digite sua senha");
    }
    $("#bloco_autorizacao input[name=tipo]").val(tipo);

    $("#bloco_autorizacao")
      .css("display", "flex")
      .stop()
      .animate({ opacity: 0 }, 0)
      .animate({ opacity: 1 }, 300, function() {
        if (tipo == 1 || tipo == 2) {
          $("#bloco_autorizacao input[name=login]").focus();
          $("#bloco_autorizacao input[name=login]").select();
        } else if (tipo == 3) {
          $("#bloco_autorizacao input[name=password]").focus();
        }
      });
  });
  var autorizacao_fechar = function() {
    $(".bloco_esperando_autorizacao").removeClass(
      "bloco_esperando_autorizacao"
    );
    $("#bloco_autorizacao")
      .stop()
      .animate({ opacity: 0 }, 300, function() {
        $(this).hide();
        $("#bloco_autorizacao input[name=login]").val("");
        $("#bloco_autorizacao input[name=password]").val("");
      });
  };
  $("#bloco_autorizacao i.fechar").click(function() {
    autorizacao_fechar();
  });
  $("#bloco_autorizacao").click(function(e) {
    if ($(e.target).attr("id") == "bloco_autorizacao") autorizacao_fechar();
  });
  $("#bloco_autorizacao button").click(function() {
    var form = $(this).closest("form");
    var link = form.attr("action");

    var login = $("input[name=login]", form).val();
    var password = $("input[name=password]", form).val();
    var tipo = $("input[name=tipo]", form).val();

    if (SISTEMA == "producao") {
      $.loading("show");
    }
    $.post(
      link,
      {
        login: login,
        password: password,
        tipo: tipo
      },
      function(resposta) {
        if (resposta.erro == false) {
          $(".bloco_esperando_autorizacao").removeClass("bloco_admin");

          if (tipo == 3) {
            $(".bloco_admin").each(function() {
              if ($("span", this).attr("data-admin") == 3) {
                $(this).removeClass("bloco_admin");
              }
            });
          }
          autorizacao_fechar();
        } else {
          $.alerta({
            notificacao: resposta.texto
          });
        }
        $.loading("hide");
      },
      "json"
    );
    return false;
  });

  /**
   * SISTEMA DE ADD ENDEREÇO
   **/
  var abrir_mapa = function(id, latitude, longitude, imagem) {
    $.mapa({
      id: id,
      latitude: latitude,
      longitude: longitude,
      icone: imagem,
      zoom: 19,
      draggable: true,
      input_latitude: "#bloco_endereco input[name=latitude]",
      input_longitude: "#bloco_endereco input[name=longitude]",
      como_chegar: "#bloco_endereco_como_chegar"
    });
  };
  var endereco_abrir = function() {
    $("#bloco_endereco")
      .stop()
      .css("display", "flex")
      .animate({ opacity: 0 }, 0)
      .animate({ opacity: 1 }, 300);

    var icone = LINK + "/images/painel/mapa.png";
    var latitude = $("#bloco_endereco .bloco_mapa input[name=latitude]").val();
    var longitude = $(
      "#bloco_endereco .bloco_mapa input[name=longitude]"
    ).val();
    if (latitude == "" || longitude == "") {
      icone = "";
      latitude = "-15.7941569";
      longitude = "-47.8825289";
    }
    abrir_mapa("bloco_endereco_mapa", latitude, longitude, icone);
  };
  var endereco_fechar = function() {
    $("#bloco_endereco")
      .stop()
      .animate({ opacity: 0 }, 300, function() {
        $("#bloco_endereco").hide();
        $("#bloco_endereco .bloco_conteudo").html("");
      });
  };
  // Abre o endereço
  $("body").on("click", ".but_add_endereco", function() {
    if (SISTEMA == "producao") {
      $.loading("show");
    }
    var cod = $(this).attr("data-cod");
    var app = $(this).attr("data-app");
    var bloco = $(this).attr("data-id");
    var local = $(this).attr("data-local");

    $("#bloco_endereco .bloco_conteudo").load(
      PAINEL + "/endereco/add",
      {
        cod: cod,
        app: app,
        local: local,
        bloco: bloco
      },
      function() {
        $.loading("hide");
        endereco_abrir();
      }
    );
    return false;
  });
  // Edita o endereço
  $("body").on("click", ".but_editar_endereco", function() {
    if (SISTEMA == "producao") {
      $.loading("show");
    }
    var id = $(this).attr("data-id");
    var app = $(this).attr("data-app");
    var local = $(this).attr("data-local");
    var bloco =
      "#" +
      $(this)
        .closest(".form_lista")
        .attr("id");

    $("#bloco_endereco .bloco_conteudo").load(
      PAINEL + "/endereco/editar",
      {
        id: id,
        app: app,
        bloco: bloco,
        local: local
      },
      function() {
        $.loading("hide");
        endereco_abrir();
      }
    );
    return false;
  });
  // Fecha o endereço
  $("#bloco_endereco").click(function(e) {
    if ($(e.target).attr("id") == "bloco_endereco") endereco_fechar();
  });
  $("#bloco_endereco").on("click", "header i.fechar", function() {
    endereco_fechar();
  });

  // Busca o endereço e a latitude pelo CEP
  $("#bloco_endereco").on("change", "input[name=cep]", function() {
    var bloco = $(this).closest("form");
    var valor = $(this).val();

    var latitude = $("#bloco_endereco input[name=latitude]").val();
    var longitude = $("#bloco_endereco input[name=longitude]").val();

    $.post(
      PAINEL + "/api-cep",
      {
        cep: valor
      },
      function(resposta) {
        if (resposta.erro == false) {
          $("input[name=bairro]", bloco).val(resposta.bairro);
          $("input[name=cidade]", bloco).val(resposta.cidade);
          $("input[name=logradouro]", bloco).val(resposta.logradouro);
          $("select[name=estado]", bloco).val(resposta.estado);

          if (resposta.logradouro == "")
            $("input[name=logradouro]", bloco).focus();
          else $("input[name=numero]", bloco).focus();
        } else {
          $("input[name=bairro]", bloco).val("");
          $("input[name=cidade]", bloco).val("");
          $("input[name=logradouro]", bloco).val("");
          $("select[select=estado]", bloco).val("");

          $("input[name=logradouro]", bloco).focus();
        }
      },
      "json"
    );

    if (latitude == "" || longitude == "") {
      $.post(
        PAINEL + "/api-mapa",
        {
          local: valor
        },
        function(resposta) {
          if (resposta.erro == false) {
            abrir_mapa(
              "bloco_endereco_mapa",
              resposta.latitude,
              resposta.longitude,
              LINK + "/images/painel/mapa.png"
            );

            $("#bloco_endereco .bloco_mapa input[name=latitude]").val(
              resposta.latitude
            );
            $("#bloco_endereco .bloco_mapa input[name=longitude]").val(
              resposta.longitude
            );
            $("#bloco_endereco_como_chegar").attr(
              "href",
              "https://www.google.com.br/maps/dir//" +
                resposta.latitude +
                ", " +
                resposta.longitude
            );
          } else {
            abrir_mapa("bloco_endereco_mapa", "-15.7941569", "-47.8825289", "");
          }
        },
        "json"
      );
    } else {
      if ($("input[name=cep]", bloco) != "")
        $("#bloco_endereco .bloco_mapa i.atualizar").addClass("atencao");
    }
    return false;
  });
  // Atualiza o mapa pelo CEP
  $("#bloco_endereco").on("click", ".bloco_mapa i.atualizar", function() {
    $.alerta({
      titulo: "Atualizar localização!",
      texto: "Tem certeza que deseja atualizar a localização deste endereço?",
      confirmar: "but_atualizar_mapa_cep"
    });
  });
  $("body").on("click", "#but_atualizar_mapa_cep", function() {
    var local = $("#bloco_endereco input[name=cep]").val();
    $("#bloco_endereco .bloco_mapa i.atualizar").removeClass("atencao");
    if (local != "") {
      $.post(
        PAINEL + "/api-mapa",
        {
          local: local
        },
        function(resposta) {
          if (resposta.erro == false) {
            abrir_mapa(
              "bloco_endereco_mapa",
              resposta.latitude,
              resposta.longitude,
              LINK + "/images/painel/mapa.png"
            );

            $("#bloco_endereco .bloco_mapa input[name=latitude]").val(
              resposta.latitude
            );
            $("#bloco_endereco .bloco_mapa input[name=longitude]").val(
              resposta.longitude
            );
            $("#bloco_endereco_como_chegar").attr(
              "href",
              "https://www.google.com.br/maps/dir//" +
                resposta.latitude +
                ", " +
                resposta.longitude
            );
          } else {
            abrir_mapa("bloco_endereco_mapa", "-15.7941569", "-47.8825289", "");
            $("#bloco_endereco_como_chegar").attr(
              "href",
              "https://www.google.com.br/maps/dir//"
            );
          }
        },
        "json"
      );
    }
  });
  // Atualiza pela latitude e longitude
  $("#bloco_endereco").on(
    "change",
    "input[name=latitude], input[name=longitude]",
    function() {
      var latitude = $("#bloco_endereco input[name=latitude]").val();
      var longitude = $("#bloco_endereco input[name=longitude]").val();

      if (latitude != "" && longitude != "") {
        abrir_mapa(
          "bloco_endereco_mapa",
          latitude,
          longitude,
          LINK + "/images/painel/mapa.png"
        );
        $("#bloco_endereco_como_chegar").attr(
          "href",
          "https://www.google.com.br/maps/dir//" + latitude + ", " + longitude
        );
      }
    }
  );
  // Cancela o ENTER
  $("#bloco_endereco").on(
    "keydown",
    "input[name=latitude], input[name=longitude]",
    function(e) {
      if (e.keyCode == 13) return false;
    }
  );

  // Salva o endereço
  $("#bloco_endereco").on("click", "#but_endereco_salvar", function() {
    var link = $("#bloco_endereco form").attr("action");
    var botao = $(this);

    var bloco = $("#bloco_endereco input[name=bloco]").val();

    var id = $("#bloco_endereco input[name=id]").val() || false;
    var cod = $("#bloco_endereco input[name=cod]").val();
    var app = $("#bloco_endereco input[name=app]").val();
    var local = $("#bloco_endereco input[name=local]").val();

    var nome = $("#bloco_endereco input[name=nome]").val();
    var cep = $("#bloco_endereco input[name=cep]").val();
    var logradouro = $("#bloco_endereco input[name=logradouro]").val();
    var numero = $("#bloco_endereco input[name=numero]").val();
    var complemento = $("#bloco_endereco input[name=complemento]").val();
    var referencia = $("#bloco_endereco input[name=referencia]").val();
    var bairro = $("#bloco_endereco input[name=bairro]").val();
    var cidade = $("#bloco_endereco input[name=cidade]").val();
    var estado = $("#bloco_endereco select[name=estado]").val();
    var latitude = $("#bloco_endereco input[name=latitude]").val();
    var longitude = $("#bloco_endereco input[name=longitude]").val();

    if (SISTEMA == "producao") {
      $.loading("show");
    }

    $.post(
      link,
      {
        id: id,
        cod: cod,
        app: app,
        local: local,
        nome: nome,
        cep: cep,
        logradouro: logradouro,
        numero: numero,
        complemento: complemento,
        referencia: referencia,
        bairro: bairro,
        cidade: cidade,
        estado: estado,
        latitude: latitude,
        longitude: longitude
      },
      function(resposta) {
        if (resposta.erro == false) {
          $(".zero", bloco).remove();
          if (resposta.id) {
            $("ul", bloco).append(
              '<li class="lista"><span class="valor">' +
                nome +
                " - " +
                logradouro +
                '</span><i data-font="&#xe807;" data-local="' +
                local +
                '" data-id="' +
                resposta.id +
                '" data-app="' +
                app +
                '" class="editar but_editar_endereco"></i></li>'
            );
          } else {
            var li = $(bloco + " li i[data-id=" + id + "]").closest("li");
            $("span.valor", li).text(nome + " - " + logradouro);
          }
          $("#bloco_endereco").click();
        } else {
          $.alerta({ notificacao: resposta.texto });
        }
        $.loading("hide");
      },
      "json"
    );

    return false;
  });
  // Deleta o endereço
  $("#bloco_endereco").on("click", "#but_endereco_deletar", function() {
    $.alerta({
      titulo: "Confirmar!",
      texto: "Deseja deletar esse endereço? Essa ação não poderá ser desfeita.",
      confirmar: "but_endereco_confirmar_deletar"
    });
    return false;
  });
  $("body").on("click", "#but_endereco_confirmar_deletar", function() {
    var id = $("#bloco_endereco form input[name=id]").val();
    var bloco = $("#bloco_endereco form input[name=bloco]").val();
    $.post(
      PAINEL + "/post-endereco-deletar",
      { id: id },
      function(resposta) {
        if (resposta.erro == false) {
          $(bloco + " .but_editar_endereco[data-id=" + id + "]")
            .closest("li")
            .remove();
          $("#bloco_endereco").click();
          if ($(bloco + " li.lista").size() == 0)
            $(bloco + " .bloco_conteudo").append(
              '<li class="zero">SEM DADOS NO MOMENTO</li>'
            );
        } else {
          $.alerta({
            titulo: resposta.titulo,
            texto: resposta.texto
          });
        }
      },
      "json"
    );
  });

  /**
   * SISTEMA DE ADD CONTATO
   **/
  var mensagem_abrir = function() {
    $("#bloco_contato")
      .stop()
      .css("display", "flex")
      .animate({ opacity: 0 }, 0)
      .animate({ opacity: 1 }, 300);
  };
  var mensagem_fechar = function() {
    $("#bloco_contato")
      .stop()
      .animate({ opacity: 0 }, 300, function() {
        $("#bloco_contato").hide();
        $("#bloco_contato .bloco_conteudo").html("");
      });
  };
  $("body").on("click", ".but_add_contato", function() {
    if (SISTEMA == "producao") {
      $.loading("show");
    }
    var cod = $(this).attr("data-cod");
    var app = $(this).attr("data-app");
    var bloco = $(this).attr("data-id");
    var local = $(this).attr("data-local");

    $("#bloco_contato .bloco_conteudo").load(
      PAINEL + "/contato/add",
      {
        cod: cod,
        app: app,
        local: local,
        bloco: bloco
      },
      function() {
        $.loading("hide");
        mensagem_abrir();
      }
    );
    return false;
  });

  $("body").on("click", ".but_editar_contato", function() {
    if (SISTEMA == "producao") {
      $.loading("show");
    }
    var id = $(this).attr("data-id");
    var app = $(this).attr("data-app");
    var local = $(this).attr("data-local");
    var bloco =
      "#" +
      $(this)
        .closest(".form_lista")
        .attr("id");

    $("#bloco_contato .bloco_conteudo").load(
      PAINEL + "/contato/editar",
      {
        id: id,
        app: app,
        bloco: bloco,
        local: local
      },
      function() {
        $.loading("hide");
        mensagem_abrir();
      }
    );
    return false;
  });
  $("#bloco_contato").click(function(e) {
    if ($(e.target).attr("id") == "bloco_contato") mensagem_fechar();
  });
  $("#bloco_contato").on("click", "header i.fechar", function() {
    mensagem_fechar();
  });
  $("#bloco_contato").on("click", "#but_contato_salvar", function() {
    var link = $("#bloco_contato form").attr("action");
    var botao = $(this);

    var bloco = $("#bloco_contato input[name=bloco]").val();

    var id = $("#bloco_contato input[name=id]").val() || false;
    var cod = $("#bloco_contato input[name=cod]").val();
    var app = $("#bloco_contato input[name=app]").val();
    var contato = $("#bloco_contato input[name=contato]").val();
    var documento = $("#bloco_contato input[name=documento]").val();
    var destaque = $("#bloco_contato input[name=destaque]").val();
    var local = $("#bloco_contato input[name=local]").val();
    var outro = $("#bloco_contato input[name=outro]").val();
    var tipo = $("#bloco_contato select[name=tipo]").val();

    var nome;
    var valor;
    var operadora;
    var nome_texto;
    if (tipo == 1) {
      nome = $("#bloco_contato select[name=nome_telefone]").val();
      valor = $("#bloco_contato input[name=valor_telefone]").val();
      operadora = $("#bloco_contato select[name=operadora]").val();
      nome_texto = $(
        "#bloco_contato select[name=nome_telefone] option:selected"
      ).text();
    } else {
      nome = $("#bloco_contato select[name=nome_email]").val();
      valor = $("#bloco_contato input[name=valor_email]").val();
      operadora = false;
      nome_texto = $(
        "#bloco_contato select[name=nome_email] option:selected"
      ).text();
    }
    if (nome == 6) nome_texto = outro;

    if (SISTEMA == "producao") {
      $.loading("show");
    }

    $.post(
      link,
      {
        id: id,
        cod: cod,
        app: app,
        local: local,
        tipo: tipo,
        nome: nome,
        documento: documento,
        outro: outro,
        valor: valor,
        operadora: operadora,
        contato: contato,
        destaque: destaque
      },
      function(resposta) {
        if (resposta.erro == false) {
          $(".zero", bloco).remove();
          if (resposta.id) {
            $("ul", bloco).append(
              '<li class="lista"><span class="valor">' +
                contato +
                " - " +
                valor +
                '</span><i data-font="&#xe807;" data-local="' +
                local +
                '" data-id="' +
                resposta.id +
                '" data-app="' +
                app +
                '" class="editar but_editar_contato"></i></li>'
            );
          } else {
            var li = $(bloco + " li i[data-id=" + id + "]").closest("li");
            $("span.valor", li).text(valor);
          }
          $("#bloco_contato").click();
        } else {
          $.alerta({ notificacao: resposta.texto });
        }
        $.loading("hide");
      },
      "json"
    );

    return false;
  });
  $("#bloco_contato").on("click", "#but_contato_deletar", function() {
    $.alerta({
      titulo: "Confirmar!",
      texto: "Deseja deletar esse contato? Essa ação não poderá ser desfeita.",
      confirmar: "but_contato_confirmar_deletar"
    });
    return false;
  });
  $("body").on("click", "#but_contato_confirmar_deletar", function() {
    var id = $("#bloco_contato form input[name=id]").val();
    var bloco = $("#bloco_contato form input[name=bloco]").val();

    $.post(
      PAINEL + "/post-contato-deletar",
      { id: id },
      function(resposta) {
        if (resposta.erro == false) {
          $(bloco + " .but_editar_contato[data-id=" + id + "]")
            .closest("li")
            .remove();
          $("#bloco_contato").click();
          if ($(bloco + " li.lista").size() == 0)
            $(bloco + " .bloco_conteudo").append(
              '<li class="zero">SEM CONTATO NO MOMENTO</li>'
            );
        } else {
          $.alerta({
            titulo: resposta.titulo,
            texto: resposta.texto
          });
        }
      },
      "json"
    );
  });

  $("#bloco_contato").on("change", "#input_contato_tipo", function() {
    var valor = $(this).val();
    $("#bloco_contato .outro").addClass("hide");
    $("#bloco_contato .outro input").val("");
    if (valor == 1) {
      $("#input_contato_nome_email").val(7);

      $("#input_contato_nome_telefone").removeClass("hide");
      $("#input_contato_valor_telefone").removeClass("hide");
      $("#input_contato_operadora").removeClass("hide");

      $("#input_contato_nome_email").addClass("hide");
      $("#input_contato_valor_email").addClass("hide");
    } else {
      $("#input_contato_nome_telefone").val(1);

      $("#input_contato_nome_telefone").addClass("hide");
      $("#input_contato_valor_telefone").addClass("hide");
      $("#input_contato_operadora").addClass("hide");

      $("#input_contato_nome_email").removeClass("hide");
      $("#input_contato_valor_email").removeClass("hide");
    }
  });

  $("#bloco_contato").on(
    "change",
    "#input_contato_nome_email, #input_contato_nome_telefone",
    function() {
      var tipo = $("#input_contato_tipo").val();
      var valor = $(this).val();

      if (valor == 6) {
        $("#bloco_contato .outro").removeClass("hide");
        if (tipo == 1) {
          $("#input_contato_nome_telefone").addClass("hide");
        } else {
          $("#input_contato_nome_email").addClass("hide");
        }
        $("#bloco_contato .outro input").focus();
      } else {
        $("#bloco_contato .outro input").val("");
        $("#bloco_contato .outro").addClass("hide");
        if (tipo == 1) {
          $("#input_contato_nome_telefone").removeClass("hide");
        } else {
          $("#input_contato_nome_email").removeClass("hide");
        }
      }
    }
  );
  $("#bloco_contato").on("click", ".outro span", function() {
    var tipo = $("#input_contato_tipo").val();
    $("#bloco_contato .outro").addClass("hide");
    $("#bloco_contato .outro input").val("");

    if (tipo == 1) {
      $("#input_contato_nome_telefone").removeClass("hide");
      $("#input_contato_nome_telefone").val(1);
    } else {
      $("#input_contato_nome_email").removeClass("hide");
      $("#input_contato_nome_email").val(7);
    }
    return false;
  });

  $("#bloco_contato").on("change", "#input_contato_nome_telefone", function() {
    var valor = $(this).val();
    if (valor == 1) {
      $("#input_contato_valor_telefone").attr("data-mascara", "celular");
    } else if (valor == 2 || valor == 3 || valor == 4) {
      $("#input_contato_valor_telefone").attr("data-mascara", "telefone");
    } else if (valor == 5) {
      $("#input_contato_valor_telefone").attr("data-mascara", "numero_espaco");
    } else {
      $("#input_contato_valor_telefone").removeAttr("data-mascara");
    }
  });

  /**
   * SISTEMA DE ADD AGENDA
   **/
  $("body").on("click", "#bloco_agenda_add button", function() {
    var form = $(this).closest("form");
    var link = form.attr("action");
    var id = $("#input_agenda_id").val();

    var dados = form_dados(form);

    if (SISTEMA == "producao") {
      $.loading("show");
    }
    $.post(
      link,
      { dados: dados },
      function(resposta) {
        if (resposta.erro == false) {
          $.alerta({ notificacao: "Agendamento criado com sucesso." });

          var visualizar_tipo;
          var icone;
          var ajuda;

          if (resposta.tipo == 1) {
            visualizar_tipo = "visualizar_telefone";
            icone = "&#xe818";
            ajuda = "Clique para ligar";
          } else if (resposta.tipo == 2) {
            visualizar_tipo = "visualizar_email";
            icone = "&#xf0e0";
            ajuda = "Clique para ver";
          } else if (resposta.tipo == 3) {
            visualizar_tipo = "visualizar_reuniao";
            icone = "&#xe80a";
            ajuda = "Clique para ver";
          } else if (resposta.tipo == 4) {
            visualizar_tipo = "visualizar_entrega";
            icone = "&#xe81a";
            ajuda = "Clique para ver";
          }
          var valor = "";
          if (dados.valor != "") valor = " - " + dados.valor;
          $(id).append(
            '<li class="lista"><span class="valor">' +
              dados.titulo +
              valor +
              '</span><i data-font="' +
              icone +
              '" data-href="' +
              PAINEL +
              "/incorporar/agenda_calendario/" +
              visualizar_tipo +
              "/par/" +
              resposta.cod +
              '" data-ajuda="' +
              ajuda +
              '" class="editar but_bloqueado_ajax"></i></li>'
          );

          if ($(id + " li.zero").size() > 0) $(id + " li.zero").remove();
          $("#plugins_pagina").click();
        } else if (resposta.erro == true) {
          $.alerta({
            titulo: resposta.titulo,
            texto: resposta.texto
          });
        }
        $.loading("hide");
      },
      "json"
    );
    return false;
  });
  // Mudar tipo
  $("body").on("change", "select[name=tipo]", function() {
    var form = $(this).closest("form");
    var tipo = $(this).val();

    $(".input_valor", form).hide();
    $(".input_valor input", form).val("");
    $(".input_valor input", form).removeAttr("data-mascara");
    if (tipo == 1) {
      $(".input_valor", form).css("display", "flex");
      $(".input_valor label", form).text("Telefone:");
      $(".input_valor input", form).attr({
        "data-mascara": "celular",
        placeholder: "(00) 0000-0000"
      });
    } else if (tipo == 2) {
      $(".input_valor", form).css("display", "flex");
      $(".input_valor label", form).text("E-mail:");
      $(".input_valor input", form).attr({
        placeholder: "email@dominio.com.br"
      });
    }
  });
  // Faz a ligação
  var janela_ligacao;
  $("body").on(
    "click",
    "#bloco_agenda_realizar .but_fazer_ligacao",
    function() {
      $("#bloco_ajuda").remove();
      if ($("#bloco_agenda_realizar .conteudo").hasClass("ligando")) {
        janela_ligacao.close();
        $("#bloco_agenda_realizar .conteudo").removeClass("ligando");
        $("#bloco_agenda_realizar .conteudo").addClass("finalizado");
        $("#bloco_agenda_realizar textarea").focus();
      } else {
        $("#bloco_agenda_realizar .conteudo").addClass("ligando");
        $("#bloco_agenda_realizar .header_voltar").remove();
        $("#bloco_agenda_realizar textarea").focus();
        $("#bloco_agenda_realizar .ligar").attr(
          "data-ajuda",
          "Encerrar ligação"
        );

        janela_ligacao = window.open(
          $(this).attr("href"),
          "janela_ligacao",
          "width=1, height=1"
        );
      }
      return false;
    }
  );
  // Cancela a ligação
  $("body").on(
    "click",
    "#bloco_agenda_realizar .but_cancelar_ligacao",
    function() {
      $("#bloco_agenda_realizar .header_voltar").remove();
      $("#bloco_agenda_realizar .conteudo").addClass("cancelado");
      $("#bloco_agenda_realizar .but_agenda_status.but_cancelar").click();
      $("#bloco_agenda_realizar .but_agenda_status").hide();
      $("#bloco_agenda_realizar .but_agenda_status").hide();
      $("#bloco_agenda_realizar textarea").focus();
      return false;
    }
  );
  // Muda o status
  $("body").on(
    "click",
    "#bloco_agenda_realizar .but_agenda_status",
    function() {
      var valor = $(this).attr("data-valor");
      $("#bloco_agenda_realizar .but_agenda_status").removeClass("ativo");
      $(this).addClass("ativo");
      $("#bloco_agenda_realizar input[name=status]").val(valor);

      if (valor == 3 || valor == 2) {
        $("#bloco_agenda_realizar .bloco_remarcar").css("display", "flex");
        $("#bloco_agenda_realizar input[name=data]").focus();
      } else {
        $("#bloco_agenda_realizar .bloco_remarcar").hide();
        $("#bloco_agenda_realizar input[name=data]").val("");
        $("#bloco_agenda_realizar input[name=hora]").val("");
      }
    }
  );
  $("body").on("click", "#bloco_agenda_realizar .daqui_hora", function() {
    var data = new Date();
    var dia = data.getDate();
    if (dia < 10) dia = "0" + dia;
    var mes = data.getMonth() + 1;
    if (mes < 10) mes = "0" + mes;
    var ano = data.getFullYear();
    var data_br = dia + "/" + mes + "/" + ano;

    var hora = data.getHours() + 1;
    if (hora < 10) hora = "0" + hora;
    var minuto = data.getMinutes();
    if (minuto < 10) dia = "0" + minuto;
    var hora_br = hora + ":" + minuto;

    $("#bloco_agenda_realizar input[name=data]").val(data_br);
    $("#bloco_agenda_realizar input[name=hora]").val(hora_br);
    $("#bloco_agenda_realizar input[name=hora]").focus();
    $("#bloco_agenda_realizar input[name=hora]").select();

    return false;
  });
  $("body").on(
    "click",
    "#bloco_agenda_realizar input[name=data], #bloco_agenda_realizar input[name=hora]",
    function() {
      $(this).select();
    }
  );
  // Salva histórico
  $("body").on("click", "#bloco_agenda_realizar button", function() {
    var form = $("#bloco_agenda_realizar form");
    var data = $("input[name=data]", form).val();
    var hora = $("input[name=hora]", form).val();
    var status = $("input[name=status]", form).val();
    var mensagem = $("textarea[name=mensagem]", form).val();
    var cod = $("input[name=cod]", form).val();

    if (SISTEMA == "producao") {
      $.loading("show");
    }
    $.post(
      PAINEL + "/incorporar/agenda_calendario/post-historico",
      {
        data: data,
        hora: hora,
        status: status,
        cod: cod,
        mensagem: mensagem
      },
      function(resposta) {
        if (resposta.erro == false) {
          $.alerta({ notificacao: "Histórico salvo com sucesso!" });
          window.location.reload();
        } else {
          $.alerta({
            titulo: resposta.titulo,
            texto: resposta.texto
          });
          $.loading("hide");
        }
      },
      "json"
    );
    return false;
  });

  /**
   * SISTEMA DE ADD
   **/
  $(".app_geral_add form input[name]:first").focus();

  /**
   * BOTAO PARA CHAMAR IMPRESSAO
   **/
  $("body").on("click", ".but_print", function() {
    window.print();
  });

  /**
   * SISTEMA SOCIAL
   **/
  var social_fechar = function() {
    $("#bloco_social")
      .stop()
      .animate({ opacity: 0 }, 300, function() {
        $(this).hide();
        $("body").css("overflow-y", "auto");
      });
  };
  $("#bloco_social").click(function(e) {
    if ($(e.target).attr("id") == "bloco_social") social_fechar();
  });
  $("#bloco_social header i").click(function() {
    social_fechar();
    return false;
  });
  $(".but_social_abrir").click(function() {
    $("body").css("overflow-y", "hidden");
    $("#bloco_social")
      .stop()
      .css("display", "flex")
      .animate({ opacity: 0 }, 0)
      .animate({ opacity: 1 }, 300);
    return false;
  });

  /**
   * SISTEMA SENHA
   **/
  var senha_fechar = function() {
    $("#bloco_senha")
      .stop()
      .animate({ opacity: 0 }, 300, function() {
        $(this).hide();
        $("body").css("overflow-y", "auto");
      });
  };
  $("#bloco_senha").click(function(e) {
    if ($(e.target).attr("id") == "bloco_senha") senha_fechar();
  });
  $("#bloco_senha header i").click(function() {
    senha_fechar();
    return false;
  });
  $(".but_senha_abrir").click(function() {
    $("body").css("overflow-y", "hidden");
    $("#bloco_senha input").val("");
    $("#bloco_senha")
      .stop()
      .show()
      .animate({ opacity: 0 }, 0)
      .animate({ opacity: 1 }, 300);
    return false;
  });
  $("#bloco_senha button").click(function() {
    var form = $("#bloco_senha form");
    var link = form.attr("action");
    var atual = $("input[name=atual]", form).val();
    var password = $("input[name=password]", form).val();
    var password_2 = $("input[name=password_2]", form).val();

    if (SISTEMA == "producao") {
      $.loading("show");
    }
    $.post(
      link,
      {
        atual: atual,
        password: password,
        password_2: password_2
      },
      function(resposta) {
        if (resposta.erro == false) {
          $.alerta({ notificacao: "Senha alterada com sucesso." });
          senha_fechar();
        } else {
          $.alerta({
            titulo: resposta.titulo,
            texto: resposta.texto
          });
        }
        $.loading("hide");
      },
      "json"
    );

    return false;
  });

  /**
   * SISTEMA BLOQUEIO
   **/
  var bloquear_fechar = function() {
    $("#bloco_bloquear")
      .stop()
      .animate({ opacity: 0 }, 300, function() {
        $(this).hide();
        $("body").css("overflow-y", "auto");
      });
  };
  $(".but_bloquear_abrir").click(function() {
    $("body").css("overflow-y", "hidden");
    $("#bloco_bloquear input").val("");

    $("#bloco_bloquear")
      .stop()
      .show()
      .animate({ opacity: 0 }, 0)
      .animate({ opacity: 1 }, 300);

    $.post(PAINEL + "/sessao", {
      nome: "BLOQUEADO",
      valor: 1
    });

    return false;
  });
  $("#bloco_bloquear button").click(function() {
    var form = $("#bloco_bloquear form");
    var link = form.attr("action");
    var password = $("input[name=password]", form).val();

    if (SISTEMA == "producao") {
      $.loading("show");
    }
    $.post(
      link,
      {
        password: password
      },
      function(resposta) {
        if (resposta.erro == false) {
          $.alerta({ notificacao: "Usuário desbloqueado com sucesso." });
          bloquear_fechar();
        } else {
          $.alerta({
            titulo: resposta.titulo,
            texto: resposta.texto
          });
        }
        $.loading("hide");
      },
      "json"
    );

    return false;
  });

  /**
   * FUNCOES DO SCROLL
   **/
  var header_scroll = function(scroll, topo) {
    if (scroll >= topo || $("#conteudo_site").hasClass("fechado")) {
      $(".header_principal_animacao").addClass("header_principal_fixed");
      $(".header_principal_animacao").removeClass("header_principal_absolute");
    } else {
      $(".header_principal_animacao").addClass("header_principal_absolute");
      $(".header_principal_animacao").removeClass("header_principal_fixed");
    }
  };
  var header_principal;
  if ($(".header_principal_animacao").size() > 0)
    header_principal = $(".header_principal_animacao").offset().top;
  else header_principal = 0;
  if (header_principal)
    header_scroll($(document).scrollTop(), header_principal);

  var voltar_topo = function(scroll) {
    if (scroll > 200) {
      $("#voltar_topo").removeClass("hide");
    } else {
      $("#voltar_topo").addClass("hide");
    }
  };
  voltar_topo($(document).scrollTop());

  $(document).scroll(function() {
    var scroll = $(document).scrollTop();
    if (header_principal) header_scroll(scroll, header_principal);

    voltar_topo(scroll);
  });

  /**
   * BOTAO DE VOLTAR AO TOPO
   **/
  $("#voltar_topo").click(function() {
    $("body, html").animate({ scrollTop: 0 }, 300);
    return false;
  });

  /**
   * MENU DE ADDS MOBILE
   **/
  $(".but_menu_add_mobile").click(function() {
    $(this).hide();
    $(".bloco_controlador").show();
  });
  $(".bloco_controlador .visualizar").click(function() {
    $(".but_menu_add_mobile").show();
    $(".bloco_controlador").hide();
  });

  /**
   * MARCA E DESMARCA TODOS
   **/
  $("body").on(
    "change",
    ".bloco_checkbox_todos input[data-name=todos]",
    function() {
      var bloco = $(this).closest("fieldset");
      if ($(this).is(":checked")) {
        $("input[type=checkbox]", bloco).prop("checked", true);
      } else {
        $("input[type=checkbox]", bloco).prop("checked", false);
      }
    }
  );
  $("body").on(
    "change",
    ".bloco_checkbox_todos input[data-name!=todos]",
    function() {
      var bloco = $(this).closest("fieldset");
      var quantidade = $("input[data-name!=todos]", bloco).size();
      var conta = 0;
      $("input[data-name!=todos]", bloco).each(function() {
        if ($(this).is(":checked")) conta++;
      });

      if (conta == quantidade)
        $("input[data-name=todos]", bloco).prop("checked", true);
      else $("input[data-name=todos]", bloco).removeAttr("checked");
    }
  );

  /**
   * DOWNLOAD GERAL
   **/
  $("body").on("click", "#but_download_geral", function() {
    var form = $(this).closest("form");
    var link = form.attr("action");
    var app = $("input[name=app]", form).val();

    var coluna = false;
    $("input[type=checkbox]", form).each(function() {
      if ($(this).is(":checked")) coluna = true;
    });

    if (!coluna) {
      $.alerta({
        titulo: "Campo obrigatório!",
        texto: "Escolha um ou mais campos para continuar."
      });
      return false;
    }
  });

  /**
   * MARCAR LISTA
   **/
  var visualizar_marcar = function(botao) {
    if (botao.hasClass("selecionado")) {
      botao.removeClass("selecionado");
    } else {
      botao.addClass("selecionado");
    }

    var ul = botao.closest("ul");
    if ($("li.selecionado", ul).size() > 0) {
      $(".bloco_selecionado").removeClass("hide");
    } else {
      $(".bloco_selecionado").addClass("hide");
    }
  };
  var visualizar_click = false;
  $("body").on("dblclick", ".but_visualizar_geral", function() {
    visualizar_click = true;
    var aguarde = setTimeout(function() {
      visualizar_click = false;
    }, 305);

    if ($("#plugins_loading").is(":visible")) return false;

    visualizar_marcar($(this));
  });
  $("body").on("click", ".but_visualizar_geral", function() {
    var botao = $(this);
    var ul = botao.closest("ul");

    if ($("li.selecionado", ul).size() > 0) {
      visualizar_marcar(botao);
    } else {
      var aguarde = setTimeout(function() {
        if (!visualizar_click) {
          window.location.assign($("a", botao).attr("href"));
        }
      }, 300);
    }
    return false;
  });

  if ($(".menu_scroll").size() > 0) {
    $(".menu_scroll").each(function() {
      var menu = $("ul", this);
      var tamanho = 0;
      $("li", menu).each(function() {
        var li = $(this);
        tamanho += li.width();
      });
      menu.css("width", tamanho);
    });
  }

  /**
   * MENU BLOCO ABRIR
   **/
  $(".but_bloco_abrir").click(function() {
    var id = $(this).attr("data-id");
    var classes = $(this).attr("data-class");
    var bloco = $(this).closest(".menu_bloco_abrir");
    $(".but_bloco_abrir", bloco).removeClass("hover");
    $(this).addClass("hover");

    $(classes).hide();
    $(id).show();
  });

  /**
   * MENU PRINCIPAL
   **/
  $("#menu_principal ul.menu_principal .menu_titulo").click(function() {
    var li = $(this).closest(".li_principal");
    if (!$(".menu_sub", li).hasClass("hover")) {
      $(".menu_sub", li).addClass("hover");
    } else {
      $(".menu_sub", li).removeClass("hover");
    }
  });
  /**
   * MENU TOPO
   **/
  if ($(window).width() <= 1100 && $("#conteudo_site").hasClass("aberto")) {
    $("#conteudo_site").removeClass("aberto");
    $("#conteudo_site").addClass("fechado");
  }
  var menu = function(acao) {
    var valor;
    if (acao == "abrir") {
      $("#conteudo_site").removeClass("fechado");
      $("#conteudo_site").addClass("aberto");
      valor = "aberto";
    } else if (acao == "fechar") {
      $("#conteudo_site").addClass("fechado");
      $("#conteudo_site").removeClass("aberto");
      valor = "fechado";
    }
    $.post(PAINEL + "/sessao", { nome: "MENU", valor: valor });
  };
  $("#menu_topo").click(function() {
    if ($("#conteudo_site").hasClass("fechado")) menu("abrir");
    else menu("fechar");
    if (header_principal)
      header_scroll($(document).scrollTop(), header_principal);
  });
  $("#menu_principal").click(function() {
    menu("fechar");
  });
  $("#menu_principal .conteudo").click(function(e) {
    e.stopPropagation();
  });
  $("#botao_mobile").swiperight(function() {
    menu("abrir");
  });
  $("#menu_principal").swipeleft(function() {
    menu("fechar");
  });

  /**
   * BUSCA PRINCIPAL
   **/
  $("#busca_principal input").focus(function() {
    var valor = $(this).val();
    $("#busca_principal").addClass("ativo");
    $("body").css("overflow", "hidden");
  });
  var busca_principal;
  $("#busca_principal input").keyup(function() {
    var link = $("#busca_principal form").attr("action");
    var busca = $(this).val();

    if (busca_principal) busca_principal.abort();
    busca_principal = $.post(
      link,
      {
        busca: busca
      },
      function(resposta) {
        $("#conteudo_busca").html(resposta);
      }
    );
  });
  $("#busca_principal i.fechar").click(function() {
    $("#busca_principal").removeClass("ativo");
    $("body").css("overflow", "auto");
  });
  $("#busca_principal button").click(function() {
    return false;
  });

  /**
   * SISTEMA DE AUDITORIA DOS PARCEIROS
   **/
  $("body").on("click", "#but_auditoria_salvar", function() {
    var form = $(this).closest("form");
    var link = form.attr("action");
    var cod = $("input[name=cod]", form).val();
    var problema = $("select[name=problema]", form).val();
    var mensagem = $("textarea[name=mensagem]", form).val();

    if (SISTEMA == "producao") {
      $.loading("show");
    }
    $.post(
      link,
      {
        cod: cod,
        problema: problema,
        mensagem: mensagem
      },
      function(resposta) {
        $.loading("hide");
        if (resposta.erro == false) {
          $.alerta({ notificacao: "Auditoria confirmada com sucesso!" });
          $(".but_fechar_ajax").click();
          if ($("li.li[data-cod=" + cod + "]").size() == 1) {
            $("li.li[data-cod=" + cod + "]").remove();
          } else if ($(".bloco_auditoria").size() == 1) {
            $(".bloco_auditoria p time").text("Agora");
            $(".bloco_auditoria .status").attr("data-ajuda", "No prazo");
            $(".bloco_auditoria .status").css("background-color", "green");
          }
        } else if (resposta.erro == true) {
          $.alerta({
            titulo: resposta.titulo,
            texto: resposta.texto
          });
        }
      },
      "json"
    );
    return false;
  });

  /**
   * CLONAR PARCEIRO
   **/
  $(".clonar_parceiro").click(function() {
    var cod = $(this).attr("data-cod");

    //$.loading('show');
    $.post(
      $("#PAINEL").val() + "/incorporar/convenio_parceiro/clonar",
      {
        cod: cod
      },
      function(resposta) {
        if (resposta.erro == false) {
          $.alerta({
            titulo: "Parceiro clonado!",
            texto: "Parceiro clonado com sucesso.",
            href:
              $("#PAINEL").val() +
              "/visualizar/convenio_parceiro/" +
              resposta.cod
          });
        } else if (resposta.erro == true) {
          $.alerta({
            titulo: resposta.titulo,
            texto: resposta.texto
          });
        } else {
          $.alerta({
            titulo: "Erro!",
            texto: "Erro ao clonar."
          });
        }
        $.loading("hide");
      },
      "json"
    );
    return false;
  });
});

CKEDITOR.replace("editor_texto", {
  height: 300,
  filebrowserUploadUrl: $('#PAINEL').val() + "/upload"
});