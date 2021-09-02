<?php
class Voucher{
    public static function pdf($dados){

        require_once("pdf/fpdf.php");

        $Painel = new PainelModel;
        $parceiro = $Painel->p_id('convenio_parceiro', $dados['app']->vinculo->valor);

        $usuario = $dados['usuario'];

        $nome = $usuario->nome->valor;
        $cpf = $usuario->documento->br;
        $data_criacao = $dados['app']->data->criacao;
        $data_vencimento = date('d/m/Y', strtotime(date('Y-m-d').' +10 days'));
        $codigo = $dados['app']->codigo;
        $desconto = utf8_decode(strip_tags($parceiro->desconto_texto));
        $observacoes = utf8_decode("Este convênio é administrado pela empresa Markt Tec Serviços em Tecnologia da Informação, CNPJ. 14.150.830/0001-00 - (Markt Club), com contrato firmado no dia 01/01/2016 e sua vigência é por prazo indeterminado. Caso tenha algum problema no ato da utilização, favor entrar em contato pelo meios abaixo:
E-mail: atendimento@marktclub.com.br
Telefone: 0800 932 0000 ramal 4199 (Apenas telefone fixo)
Whatsapp: (61) 99354-6881 (apenas WhatsApp)");

        $pdf= new FPDF("P","pt","A4");

        $pdf->AddPage();

        $pdf->Image(DIRETORIO."/parceiro/".$parceiro->imagem->clube->valor, 500, 10, 60, 60);
        $pdf->Image(DIRETORIO."/construtor/".$dados['empresa']->imagem->logo->valor, 30, 10, 230, 60, 'PNG');

        $pdf->Image("http://chart.apis.google.com/chart?cht=qr&chl=http://voucher.marktclub.com.br/".$usuario->documento->valor."&chs=163x163", 400, 178, 163, 163, 'PNG');

        $pdf->Ln(90);

        $pdf->SetFont('arial','',14);
        $pdf->Cell(0,10,utf8_decode("INFORMAÇÕES PARA UTILIZAÇÃO DO PARCEIRO:"),0,1,'C');
        $pdf->setFont('arial','B',18);
        $pdf->Cell(0,20,$parceiro->titulo,0,1,'C');
        $pdf->Ln(20);

        $pdf->SetFont('arial','B',12);
        $pdf->Cell(120,20,utf8_decode("Dados do usuário"),0,1,'L');
        $pdf->Line(140, 180, 565, 180);
        $pdf->ln(10);

        //Nome
        $pdf->SetFont('arial','',12);
        $pdf->Cell(190,20,utf8_decode("Nome do usuário:"),0,0,'L');
        $pdf->setFont('arial','B',12);
        $pdf->Cell(190,20,utf8_decode($nome),1,1,'L');
        $pdf->ln(5);

        //CPF
        $pdf->SetFont('arial','',12);
        $pdf->Cell(190,20,utf8_decode("CPF do usuário:"),0,0,'L');
        $pdf->setFont('arial','B',12);
        $pdf->Cell(190,20,$cpf,1,1,'L');
        $pdf->ln(5);

        //Data criação
        $pdf->SetFont('arial','',12);
        $pdf->Cell(190,20,utf8_decode("Data da criação do voucher:"),0,0,'L');
        $pdf->setFont('arial','B',12);
        $pdf->Cell(190,20,$data_criacao,1,1,'L');
        $pdf->ln(5);

        //Data vencimento
        $pdf->SetFont('arial','',12);
        $pdf->Cell(190,20,"Data do vencimento do voucher:",0,0,'L');
        $pdf->setFont('arial','B',12);
        $pdf->Cell(190,20,$data_vencimento,1,1,'L');
        $pdf->ln(5);

        //Código
        $pdf->SetFont('arial','',12);
        $pdf->Cell(190,20,utf8_decode("Código:"),0,0,'L');
        $pdf->setFont('arial','B',12);
        $pdf->Cell(190,20,$codigo,1,1,'L');

        $pdf->ln(25);
        //Desconto
        $pdf->SetFont('arial','',12);
        $pdf->Cell(0,20,"Desconto",'T',1,'C');
        $pdf->setFont('arial','',8);
        $pdf->MultiCell(0,20,$desconto,'B','J');

        $pdf->ln(10);
        //Observações
        $pdf->setFont('arial','',8);
        $pdf->MultiCell(0,20,$observacoes,'B','J');

        $nomearquivo = md5(uniqid(time())).".pdf";

        $pdf->Output("arquivos/voucher/".$nomearquivo, "F");
        // $pdf->Output($nomearquivo,"I");

        return $nomearquivo;

    }
    public static function salavip($dados){
        require_once("pdf/fpdf.php");

        $Painel = new PainelModel;

        $parceiro = $Painel->p_id('convenio_parceiro', $dados['app']->vinculo->valor);

        $usuario = $dados['usuario'];

        $nome = $usuario->nome->valor;
        $cpf = $usuario->documento->br;
        $data_criacao = $dados['app']->data->criacao;
        $data_vencimento = date('d/m/Y', strtotime(date('Y-m-d').' +10 days'));
        $codigo = $dados['app']->codigo;

        $data_vencimento = date('d/m/Y', strtotime(date('Y-m-d').' +10 days'));
        $desconto = utf8_decode("O TITULAR terá o direito ao uso, SEM CUSTOS, da SALA VIP DO AEROPORTO INTERNACIONAL DE BRASÍLIA – PRESIDENTE JUSCELINO KUBITSCHEK no primeiro acesso do mês. À partir do segundo acesso, o TITULAR terá desconto de 50% na tarifa vigente, devendo pagar a diferença no balcão. Os DEPENDENTES terão 50% de desconto da tarifa vigente em todos os acessos.");
        $observacoes = utf8_decode("Este convênio é administrado pela empresa Markt Tec Serviços em Tecnologia da Informação, CNPJ. 14.150.830/0001-00 - (Markt Club), com contrato firmado no dia 01/01/2016 e sua vigência é por prazo indeterminado. Caso tenha algum problema no ato da utilização, favor entrar em contato pelo meios abaixo:
E-mail: atendimento@marktclub.com.br
Telefone: 0800 932 0000 ramal 4199 (Apenas telefone fixo)
Whatsapp: (61) 99354-6881 (apenas WhatsApp)");

        $pdf= new FPDF("P","pt","A4");

        $pdf->AddPage();

        $pdf->Image("../../clube/public_html/images/salavip.jpg", 500, 10, 60, 60);
        $pdf->Image(DIRETORIO."/construtor/".$dados['empresa']->imagem->logo->valor, 30, 10, 230, 60, 'PNG');
        $pdf->Image("http://chart.apis.google.com/chart?cht=qr&chl=http://voucher.marktclub.com.br/".$usuario->documento->valor."&chs=163x163", 400, 178, 163, 163, 'PNG');

        $pdf->Ln(90);

        $pdf->SetFont('arial','',14);
        $pdf->Cell(0,10,utf8_decode("INFORMAÇÕES PARA UTILIZAÇÃO DA SALA VIP"),0,1,'C');
        $pdf->Ln(20);

        $pdf->SetFont('arial','B',12);
        $pdf->Cell(120,20,utf8_decode("Dados do usuário"),0,1,'L');
        $pdf->Line(140, 180, 565, 180);
        $pdf->ln(10);

        //Nome
        $pdf->SetFont('arial','',12);
        $pdf->Cell(190,20,utf8_decode("Nome do usuário:"),0,0,'L');
        $pdf->setFont('arial','B',12);
        $pdf->Cell(190,20,utf8_decode($nome),1,1,'L');
        $pdf->ln(5);

        //CPF
        $pdf->SetFont('arial','',12);
        $pdf->Cell(190,20,utf8_decode("CPF do usuário:"),0,0,'L');
        $pdf->setFont('arial','B',12);
        $pdf->Cell(190,20,$cpf,1,1,'L');
        $pdf->ln(5);

        //Data criação
        $pdf->SetFont('arial','',12);
        $pdf->Cell(190,20,utf8_decode("Data da criação do voucher:"),0,0,'L');
        $pdf->setFont('arial','B',12);
        $pdf->Cell(190,20,$data_criacao,1,1,'L');
        $pdf->ln(5);

        //Data vencimento
        $pdf->SetFont('arial','',12);
        $pdf->Cell(190,20,"Data do vencimento do voucher:",0,0,'L');
        $pdf->setFont('arial','B',12);
        $pdf->Cell(190,20,$data_vencimento,1,1,'L');
        $pdf->ln(5);

        //Código
        $pdf->SetFont('arial','',12);
        $pdf->Cell(190,20,utf8_decode("Código:"),0,0,'L');
        $pdf->setFont('arial','B',12);
        $pdf->Cell(190,20,$codigo,1,1,'L');

        $pdf->ln(25);
        //Desconto
        $pdf->SetFont('arial','',12);
        $pdf->Cell(0,20,"Desconto",'T',1,'C');
        $pdf->setFont('arial','',8);
        $pdf->MultiCell(0,20,$desconto,'B','J');

        $pdf->ln(10);
        //Observações
        $pdf->setFont('arial','',8);
        $pdf->MultiCell(0,20,$observacoes,'B','J');

        $nomearquivo = md5(uniqid(time())).".pdf";

        $pdf->Output("arquivos/voucher/".$nomearquivo,"F");

        return $nomearquivo;

    }
    public static function imovel($dados){
        require_once("pdf/fpdf.php");
        $Painel = new PainelModel;
        $imovel = $Painel->p_id('imovel_imovel', $dados['app']->vinculo);

        $usuario = $dados['usuario'];

        $nome = $usuario->nome->valor;
        $cpf = $usuario->documento->br;
        $data_criacao = $dados['app']->data->criacao;
        $data_vencimento = date('d/m/Y', strtotime(date('Y-m-d').' +10 days'));
        $codigo = $dados['app']->codigo;

        $data_vencimento = date('d/m/Y', strtotime(date('Y-m-d').' +10 days'));
        $desconto = $imovel->beneficio;
        $observacoes = utf8_decode("Este convênio é administrado pela empresa Markt Tec Serviços em Tecnologia da Informação, CNPJ. 14.150.830/0001-00 - (Markt Club), com contrato firmado no dia 01/01/2016 e sua vigência é por prazo indeterminado. Caso tenha algum problema no ato da utilização, favor entrar em contato pelo meios abaixo:
E-mail: atendimento@marktclub.com.br
Telefone: 0800 932 0000 ramal 4199 (Apenas telefone fixo)
Whatsapp: (61) 99354-6881 (apenas WhatsApp)");

        $pdf= new FPDF("P","pt","A4");

        $pdf->AddPage();

        $pdf->Image(DIRETORIO."/construtor/".$dados['empresa']->imagem->logo->valor, 30, 10, 230, 60, 'PNG');
        $pdf->Image("http://chart.apis.google.com/chart?cht=qr&chl=http://voucher.marktclub.com.br/".$usuario->documento->valor."&chs=163x163", 400, 178, 163, 163, 'PNG');

        $pdf->Ln(90);

        $pdf->SetFont('arial','',14);
        $pdf->Cell(0,10,utf8_decode("INFORMAÇÕES PARA UTILIZAÇÃO DO BENEFÍCIO:"),0,1,'C');
        $pdf->setFont('arial','B',18);
        $pdf->Cell(0,20,$imovel->titulo,0,1,'C');
        $pdf->Ln(20);

        $pdf->SetFont('arial','B',12);
        $pdf->Cell(120,20,utf8_decode("Dados do usuário"),0,1,'L');
        $pdf->Line(140, 180, 565, 180);
        $pdf->ln(10);

        //Nome
        $pdf->SetFont('arial','',12);
        $pdf->Cell(190,20,utf8_decode("Nome do usuário:"),0,0,'L');
        $pdf->setFont('arial','B',12);
        $pdf->Cell(190,20,utf8_decode($nome),1,1,'L');
        $pdf->ln(5);

        //CPF
        $pdf->SetFont('arial','',12);
        $pdf->Cell(190,20,utf8_decode("CPF do usuário:"),0,0,'L');
        $pdf->setFont('arial','B',12);
        $pdf->Cell(190,20,$cpf,1,1,'L');
        $pdf->ln(5);

        //Data criação
        $pdf->SetFont('arial','',12);
        $pdf->Cell(190,20,utf8_decode("Data da criação do voucher:"),0,0,'L');
        $pdf->setFont('arial','B',12);
        $pdf->Cell(190,20,$data_criacao,1,1,'L');
        $pdf->ln(5);

        //Data vencimento
        $pdf->SetFont('arial','',12);
        $pdf->Cell(190,20,"Data do vencimento do voucher:",0,0,'L');
        $pdf->setFont('arial','B',12);
        $pdf->Cell(190,20,$data_vencimento,1,1,'L');
        $pdf->ln(5);

        //Código
        $pdf->SetFont('arial','',12);
        $pdf->Cell(190,20,utf8_decode("Código:"),0,0,'L');
        $pdf->setFont('arial','B',12);
        $pdf->Cell(190,20,$codigo,1,1,'L');

        $pdf->ln(25);
        //Desconto
        $pdf->SetFont('arial','',12);
        $pdf->Cell(0,20,"Desconto",'T',1,'C');
        $pdf->setFont('arial','',8);
        $pdf->MultiCell(0,20,$desconto,'B','J');

        $pdf->ln(10);
        //Observações
        $pdf->setFont('arial','',8);
        $pdf->MultiCell(0,20,$observacoes,'B','J');

        $nomearquivo = md5(uniqid(time())).".pdf";

        $pdf->Output("arquivos/voucher/".$nomearquivo,"F");

        return $nomearquivo;

    }
}
