<?php

/**
 * EVITA INJEÇÃO DE SQL NO INTUITO DE INVASÃO
 **/
function antiInjection($string)
{
    $string = str_ireplace(" or ", "", $string);
    $string = str_ireplace("select ", "", $string);
    $string = str_ireplace("delete ", "", $string);
    $string = str_ireplace("create ", "", $string);
    $string = str_ireplace("drop ", "", $string);
    $string = str_ireplace("update ", "", $string);
    $string = str_ireplace("drop table", "", $string);
    $string = str_ireplace("show table", "", $string);
    $string = str_ireplace("'", "", $string);
    $string = str_replace("#", "", $string);
    $string = str_replace("=", "", $string);
    $string = str_replace("--", "", $string);
    $string = str_replace("-", "", $string);
    $string = str_replace(";", "", $string);
    $string = str_replace("*", "", $string);
    $string = strip_tags($string);
    $string = addslashes($string);

    return $string;
}

/**
 * GERA TÍTULO AMIGÁVEL
 **/
function tituloAmigavel($s)
{

    $trocarIsso = array('à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ü', 'ú', 'ÿ', 'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'O', 'Ù', 'Ü', 'Ú', 'Ÿ', '@', 'ª', 'º',);
    $porIsso = array('a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'y', 'A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'Y', 'a', 'a', 'o',);
    $s = str_replace($trocarIsso, $porIsso, $s);

    $s = preg_replace("/[^a-zA-Z0-9\-]/", "-", $s);
    $s = preg_replace(array("`[^a-z0-9]`i", "`[-]+`"), "-", $s);

    return strtolower(trim($s, '-'));
}

/**
 * NORMATIZAÇÃO/SANITIZAÇÃO DE UMA STRING
 **/
function normalizaURL($str)
{
    $str = mb_strtolower(utf8_decode($str));
    $i = 1;
    $str = strtr($str, utf8_decode('àáâãäåæçèéêëìíîïñòóôõöøùúûýýÿ'), 'aaaaaaaceeeeiiiinoooooouuuyyy');
    $str = preg_replace("/([^a-z0-9])/", '-', utf8_encode($str));
    while ($i > 0) $str = str_replace('--', '-', $str, $i);
    if (substr($str, -1) == '-') $str = substr($str, 0, -1);
    return $str;
}

/**
 * RETORNA O COMPONENTE DE MENSAGEM DE ACORDO COM OS ARGUMENTOS
 **/
function alerta($mensagem, $tipo)
{

    if (strlen($mensagem) == 0) {
        $ret = "";
    }
    $class = "";
    switch ($tipo):
        case "info":
            $class = "alert alert-info";
            $icone = "<i class='fa fa-info'></i>";
            break;
        case "alerta":
            $class = "alert alert-warning";
            $icone = "<i class='fa fa-exclamation'></i>";
            break;
        case "erro":
            $class = "alert alert-danger";
            $icone = "<i class='fa fa-thumbs-o-down'></i>";
            break;
        case "sucesso":
            $class = "alert alert-success";
            $icone = "<i class='fa fa-thumbs-o-up'></i>";
            break;
    endswitch;

    $ret = '<div class="' . $class . '">';
    #$ret.= '   <button type="button" aria-hidden="true" class="close" data-dismiss="alert"><i class="nc-icon nc-simple-remove"></i></button>';
    $ret .= '   <span>' . $icone . ' ' . $mensagem . '</span>';
    $ret .= "</div>";

    return $ret;
}

/**
 * VALOR POR EXTENSO
 **/
function valorPorExtenso($valor = 0, $bolExibirMoeda = true, $bolPalavraFeminina = false)
{

    $valor = removerFormatacaoNumero($valor);

    $singular = null;
    $plural = null;

    if ($bolExibirMoeda) {
        $singular = array("centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
        $plural = array("centavos", "reais", "mil", "milhões", "bilhões", "trilhões", "quatrilhões");
    } else {
        $singular = array("", "", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
        $plural = array("", "", "mil", "milhões", "bilhões", "trilhões", "quatrilhões");
    }

    $c = array("", "cem", "duzentos", "trezentos", "quatrocentos", "quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
    $d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta", "sessenta", "setenta", "oitenta", "noventa");
    $d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze", "dezesseis", "dezesete", "dezoito", "dezenove");
    $u = array("", "um", "dois", "três", "quatro", "cinco", "seis", "sete", "oito", "nove");


    if ($bolPalavraFeminina) {

        if ($valor == 1) {
            $u = array("", "uma", "duas", "três", "quatro", "cinco", "seis", "sete", "oito", "nove");
        } else {
            $u = array("", "um", "duas", "três", "quatro", "cinco", "seis", "sete", "oito", "nove");
        }


        $c = array("", "cem", "duzentas", "trezentas", "quatrocentas", "quinhentas", "seiscentas", "setecentas", "oitocentas", "novecentas");
    }


    $z = 0;

    $valor = number_format($valor, 2, ".", ".");
    $inteiro = explode(".", $valor);

    for ($i = 0; $i < count($inteiro); $i++) {
        for ($ii = mb_strlen($inteiro[$i]); $ii < 3; $ii++) {
            $inteiro[$i] = "0" . $inteiro[$i];
        }
    }

    // $fim identifica onde que deve se dar junção de centenas por "e" ou por "," ;)
    $rt = null;
    $fim = count($inteiro) - ($inteiro[count($inteiro) - 1] > 0 ? 1 : 2);
    for ($i = 0; $i < count($inteiro); $i++) {
        $valor = $inteiro[$i];
        $rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
        $rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
        $ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";

        $r = $rc . (($rc && ($rd || $ru)) ? " e " : "") . $rd . (($rd && $ru) ? " e " : "") . $ru;
        $t = count($inteiro) - 1 - $i;
        $r .= $r ? " " . ($valor > 1 ? $plural[$t] : $singular[$t]) : "";
        if ($valor == "000")
            $z++;
        elseif ($z > 0)
            $z--;

        if (($t == 1) && ($z > 0) && ($inteiro[0] > 0))
            $r .= (($z > 1) ? " de " : "") . $plural[$t];

        if ($r)
            $rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? (($i < $fim) ? ", " : " e ") : " ") . $r;
    }

    $rt = mb_substr($rt, 1);

    return ($rt ? trim($rt) : "zero");
}

/**
 * REMOVE A FORMATAÇÃO DOS NÚMEROS
 **/
function removerFormatacaoNumero($strNumero)
{

    $strNumero = trim(str_replace("R$", "", $strNumero));

    $vetVirgula = explode(",", $strNumero);
    if (count($vetVirgula) == 1) {
        $acentos = array(".");
        $resultado = str_replace($acentos, "", $strNumero);
        return $resultado;
    } else if (count($vetVirgula) != 2) {
        return $strNumero;
    }

    $strNumero = $vetVirgula[0];
    $strDecimal = mb_substr($vetVirgula[1], 0, 2);

    $acentos = array(".");
    $resultado = str_replace($acentos, "", $strNumero);
    $resultado = $resultado . "." . $strDecimal;

    return $resultado;
}

/**
 * RETORNAR APENAS OS NÚMEROS DO PARÂMETRO
 **/
function soNumeros($param)
{
    return preg_replace('/[^0-9]/i', '', $param);
}

/**
 * RETORNAR APENAS A IDADE
 **/
function calculaIdade($data)
{
    // Declara a data! :P
    //$data = '29/08/2008';

    // Separa em dia, mês e ano
    list($dia, $mes, $ano) = explode('/', $data);

    // Descobre que dia é hoje e retorna a unix timestamp
    $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
    // Descobre a unix timestamp da data de nascimento do fulano
    $nascimento = mktime(0, 0, 0, $mes, $dia, $ano);

    // Depois apenas fazemos o cálculo já citado :)
    $idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);

    return $idade . " anos";
}

/**
 * RETORNAR DATA PARA BANCO MYSQL
 **/
function dataBanco($data)
{

    list($dia, $mes, $ano) = explode('/', $data);

    $data_banco = $ano . "-" . $mes . "-" . $dia;

    return $data_banco;
}

/**
 * RETORNAR DATA DE BANCO MYSQL PARA APLICAÇÃO
 **/
function dataBancoApp($data)
{

    list($ano, $mes, $dia) = explode('-', $data);

    $data_banco = $dia . "/" . $mes . "/" . $ano;

    return $data_banco;
}

/**
 * RETORNAR DATA VÁLIDA
 **/
function dataValida($data)
{

    list($dia, $mes, $ano) = explode('/', $data);

    if (!checkdate($mes, $dia, $ano)) {
        return false;
    } else {
        return true;
    }
}

/**
 * VALIDAÇÃO DE CPF
 **/
function validar_cpf($cpf)
{
    $cpf = preg_replace('/[^0-9]/', '', (string) $cpf);

    // Valida tamanho
    if (strlen($cpf) != 11) {
        return false;
    }

    $invalidos = array('00000000000', '11111111111', '22222222222', '33333333333', '44444444444', '55555555555', '66666666666', '77777777777', '88888888888', '99999999999');

    if (in_array($cpf, $invalidos)) {
        return false;
    }

    // Calcula e confere primeiro dígito verificador
    for ($i = 0, $j = 10, $soma = 0; $i < 9; $i++, $j--) :
        $soma += $cpf[$i] * $j;
    endfor;

    $resto = $soma % 11;

    if ($cpf[9] != ($resto < 2 ? 0 : 11 - $resto)) {
        return false;
    }

    // Calcula e confere segundo dígito verificador
    for ($i = 0, $j = 11, $soma = 0; $i < 10; $i++, $j--) :
        $soma += $cpf[$i] * $j;
    endfor;

    $resto = $soma % 11;

    #return $cpf{10} == ($resto < 2 ? 0 : 11 - $resto);
    if ($cpf[10] != ($resto < 2 ? 0 : 11 - $resto)) {
        return false;
    }

    return true;
}

/**
 * VALIDAÇÃO DE CNPJ
 **/
function validar_cnpj($cnpj)
{
    $cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);
    // Valida tamanho
    if (strlen($cnpj) != 14) {
        return false;
    }

    $invalidos = array('00000000000', '11111111111', '22222222222', '33333333333', '44444444444', '55555555555', '66666666666', '77777777777', '88888888888', '99999999999');
    if (in_array($cnpj, $invalidos)) {
        return false;
    }

    // Valida primeiro dígito verificador
    for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++) :
        $soma += $cnpj[$i] * $j;
        $j = ($j == 2) ? 9 : $j - 1;
    endfor;

    $resto = $soma % 11;

    if ($cnpj[12] != ($resto < 2 ? 0 : 11 - $resto)) {
        return false;
    }

    // Valida segundo dígito verificador
    for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++) :
        $soma += $cnpj[$i] * $j;
        $j = ($j == 2) ? 9 : $j - 1;
    endfor;

    $resto = $soma % 11;

    #return $cnpj{13} == ($resto < 2 ? 0 : 11 - $resto);
    if ($cnpj[13] != ($resto < 2 ? 0 : 11 - $resto)) {
        return false;
    }

    return true;
}

/**
 * APLICA UMA MASCARA A UM VALOR
 * Ex: Mascara = "(99) 9999-9999";
 *     Valor   = "8698765432";
 * Retorno: (86) 9876-5432
 **/
function aplicaMascara($mascara, $valor)
{

    $resultado = "";
    $valor = trim($valor);
    if (strlen($valor) > 0) {
        if (strlen($valor) > strlen($mascara))
            $valor = substr($valor, 0, strlen($mascara)); //Trunca o valor ao tamanho da mascara
        $ind = 0;
        for ($i = 0; $i < strlen($mascara); $i++) {
            if (substr($mascara, $i, 1) == "9") { //Imprime o dado
                $resultado = $resultado . substr($valor, $ind, 1);
                $ind++;
            } elseif (substr($mascara, $i, 1) == "X") { //Imprime o dado
                $resultado = $resultado . strtoupper(substr($valor, $ind, 1));
                $ind++;
            } else
            if ($ind <= strlen($valor))
                $resultado = $resultado . substr($mascara, $i, 1);
        }
    }
    return  $resultado;
}

/**
 * Retornar token guid para 
 **/
function getGUID($par)
{

    //mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.

    $charid = strtoupper(md5($par));
    $hyphen = chr(45); // "-"
    $uuid = substr($charid, 0, 8) . $hyphen . substr($charid, 8, 4) . $hyphen . substr($charid, 12, 4) . $hyphen . substr($charid, 16, 4) . $hyphen . substr($charid, 20, 12);

    return $uuid;
}

/**
 * Retornar Hash
 * md5           32 5d41402abc4b2a76b9719d911017c592
 * sha1          40 aaf4c61ddcc5e8a2dabede0f3b482cd9aea9434d
 * sha256        64 2cf24dba5fb0a30e26e83b2ac5b9e29e1b161e5c1fa7425e730
 * sha384        96 59e1748777448c69de6b800d7a33bbfb9ff1b463e44354c3553
 * sha512       128 9b71d224bd62f3785d96d46ad3ea3d73319bfbc2890caadae2d
 **/
function geraHash($tipo, $string)
{

    switch ($tipo):
        case 'md5':
            return md5($string);
            break;
        case 'sha1':
            return hash('sha1', $string);
            break;
        case 'sha256':
            return hash('sha256', $string);
            break;
        case 'sha384':
            return hash('sha384', $string);
            break;
        case 'sha512':
            return hash('sha512', $string);
            break;
    endswitch;
}

/**
 * CALCULA O PROXIMO AGRUPAMENTO DE PAGINAS
 **/
function calcula_proximo_agrupamento($pag, $registros, $tamanho)
{

    # TOTAL REGISTROS
    $tot_pag = ceil($registros / $tamanho);

    if ($pag > $tot_pag) {
        $pag = $tot_pag;
    }

    if (($pag == "") or ($pag <= 0)) {
        $pag = 1;
    }

    # CALCULO DO REG INICIAL DA PAGINA ATUAL (INICIO É 0)
    return $tamanho * ($pag - 1);
}

/**
 * RETORNA FRAGMENTO DE NOME DO PACIENTE
 **/
function fragmentoNome($palavra)
{
    $ex = explode(" ", $palavra);
    return $ex[0];
}

/**
 * RETORNA O IP
 **/
function getIP()
{

    $ipaddress = "";

    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if (getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if (getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if (getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if (getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if (getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';

    return $ipaddress;
}

/**
 * DIFERENÇA ENTRE DATAS EM DIAS
 **/
function diasEntreDatas($data_ini, $data_fim)
{

    $date1 = date_create($data_ini);
    $date2 = date_create($data_fim);
    $diff = date_diff($date1, $date2);
    return $diff->format("%a");
}

/**
 * Generates a string representation for the given byte count.
 *
 * @param $size
 *   A size in bytes.
 *
 * @return
 *   A string representation of the size.
 */
function format_size($size)
{
    if ($size < 1024) {
        return $size . ' B';
    } else {
        $size = $size / 1024;
        $units = ['KB', 'MB', 'GB', 'TB'];
        foreach ($units as $unit) {
            if (round($size, 2) >= 1024) {
                $size = $size / 1024;
            } else {
                break;
            }
        }
        return round($size, 2) . ' ' . $unit;
    }
}
