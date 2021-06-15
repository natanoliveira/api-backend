<?php
function anti_injection($string)
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

function TituloAmigavel($s)
{
    /* 
    $s = strtolower($s);
    $s = preg_replace("[áàâãäª@]","a",$s);
    $s = preg_replace("[éèêë]","e",$s);
    $s = preg_replace("[íìîï]","i",$s);
    $s = preg_replace("[óòôõºö]","o",$s);
    $s = preg_replace("[úùûü]","u",$s);
    $s = preg_replace("[ç]","c",$s);
    $s = preg_replace("[ñ]","n",$s);
    */
    $trocarIsso = array('à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ü', 'ú', 'ÿ', 'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'O', 'Ù', 'Ü', 'Ú', 'Ÿ', '@', 'ª', 'º',);
    $porIsso = array('a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'y', 'A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'Y', 'a', 'a', 'o',);
    $s = str_replace($trocarIsso, $porIsso, $s);

    $s = preg_replace("/[^a-zA-Z0-9\-]/", "-", $s);
    $s = preg_replace(array("`[^a-z0-9]`i", "`[-]+`"), "-", $s);

    return strtolower(trim($s, '-'));
}

function gera_titulo_documento($s)
{
    /* 
    $s = strtolower($s);
    $s = preg_replace("[áàâãäª@]","a",$s);
    $s = preg_replace("[éèêë]","e",$s);
    $s = preg_replace("[íìîï]","i",$s);
    $s = preg_replace("[óòôõºö]","o",$s);
    $s = preg_replace("[úùûü]","u",$s);
    $s = preg_replace("[ç]","c",$s);
    $s = preg_replace("[ñ]","n",$s);
    */
    $trocarIsso = array('à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ü', 'ú', 'ÿ', 'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'O', 'Ù', 'Ü', 'Ú', 'Ÿ', '@', 'ª', 'º',);
    $porIsso = array('a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'y', 'A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'Y', 'a', 'a', 'o',);
    $s = str_replace($trocarIsso, $porIsso, $s);

    $s = preg_replace("/[^a-zA-Z0-9\-]/", "_", $s);
    $s = preg_replace(array("`[^a-z0-9]`i", "`[-]+`"), "_", $s);

    return strtolower(trim($s, '_'));
}

function NormalizaURL($str)
{
    $str = mb_strtolower(utf8_decode($str));
    $i = 1;
    $str = strtr($str, utf8_decode('àáâãäåæçèéêëìíîïñòóôõöøùúûýýÿ'), 'aaaaaaaceeeeiiiinoooooouuuyyy');
    $str = preg_replace("/([^a-z0-9])/", '-', utf8_encode($str));
    while ($i > 0) $str = str_replace('--', '-', $str, $i);
    if (substr($str, -1) == '-') $str = substr($str, 0, -1);
    return $str;
}

function geraDescricaoArquivo($s)
{
    /* 
    $s = strtolower($s);
    $s = preg_replace("[áàâãäª@]","a",$s);
    $s = preg_replace("[éèêë]","e",$s);
    $s = preg_replace("[íìîï]","i",$s);
    $s = preg_replace("[óòôõºö]","o",$s);
    $s = preg_replace("[úùûü]","u",$s);
    $s = preg_replace("[ç]","c",$s);
    $s = preg_replace("[ñ]","n",$s);
    */
    $trocarIsso = array('à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ü', 'ú', 'ÿ', 'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'O', 'Ù', 'Ü', 'Ú', 'Ÿ', '@', 'ª', 'º',);
    $porIsso = array('a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'y', 'A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'N', 'O', 'O', 'O', 'O', 'O', '0', 'U', 'U', 'U', 'Y', 'a', 'a', 'o',);
    $s = str_replace($trocarIsso, $porIsso, $s);

    $s = preg_replace("/[^a-zA-Z0-9\-]/", "_", $s);
    $s = preg_replace(array("`[^a-z0-9]`i", "`[-]+`"), "_", $s);

    return trim($s, '-');
}
/*
# prepara nomenclatura para arquivos anexado
function nome($extensao,$dir){
  
    global $propriedade;

  $temp = substr(md5(uniqid(time())), 0, 10);
  $anexo_nome = $temp . "." . $extensao;
  
  if(file_exists($dir . $anexo_nome)) {
      $anexo_nome = nome($extensao);
  }
  return $anexo_nome;
}
*/
# funcao modificada para layout novo do painel
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
 * Retornar apenas os números do parâmetro
 **/
function soNumeros($param)
{
    return preg_replace('/[^0-9]/i', '', $param);
}

/**
 * Retornar apenas a idade
 **/
function CalculaIdade($data)
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
 * Retornar data para banco mysql
 **/
function DataBanco($data)
{

    list($dia, $mes, $ano) = explode('/', $data);

    $data_banco = $ano . "-" . $mes . "-" . $dia;

    return $data_banco;
}

/**
 * Retornar data de banco mysql para aplicação
 **/
function DataBancoApp($data)
{

    list($ano, $mes, $dia) = explode('-', $data);

    $data_banco = $dia . "/" . $mes . "/" . $ano;

    return $data_banco;
}

/**
 * Retornar data válida
 **/
function DataValida($data)
{

    list($dia, $mes, $ano) = explode('/', $data);

    if (!checkdate($mes, $dia, $ano)) {
        return false;
    } else {
        return true;
    }
}

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
 * @abstract Tratamento de injections em formulários.
 * @return string
 */

function diasPostagem($data)
{

    $diferenca = strtotime(date('Y-m-d')) - strtotime($data);
    $dias = floor($diferenca / (60 * 60 * 24));

    /*
    switch ($dias) {
     case 0:
      return 'Postagem feita Hoje.'; 
      break;
     case 1:
      return 'Postagem feita Ontem.'; 
      break;
     default:
      return "Postagem feita há $dias atrás.";
      break;
    }
  */

    if ($dias == 0) {
        return 'Hoje';
    } elseif ($dias == 1) {
        return 'Ontem';
    }
    #elseif ($dias>=1 && $dias<=30) {
    #  return '1 mês';
    #}
    #elseif ($dias > 30) {
    #  return 'a meses';
    #}
    #elseif ($dias>=365) {
    #  return '1 ano ou mais';
    #}
    else {
        return DataBancoApp($data);
    }
}

function aplica_mascara($mascara, $valor)
{
    # aplica uma mascara a um valor
    # Ex: Mascara = "(99) 9999-9999";
    #     Valor   = "8698765432";
    # Retorno: (86) 9876-5432

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
/*
function GeraHash($tipo, $string){
    
    switch ($tipo) :
        case 'md5': return md5($string); break;
        case 'sha1': return hash('sha1', $string); break;
        case 'sha256': return hash('sha256', $string); break;
        case 'sha384': return hash('sha384', $string); break;
        case 'sha512': return hash('sha512', $string); break;
    endswitch;

}
*/

/*
  Calcula o Proximo Agrupamento de Paginas
*/
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

/*
    Retorna o valor do status de atendimento para filtro
*/
function StatusAgendamentoFitro($status)
{

    switch ($status):
        case "AG":
            $valor = 0;
            break;
        case "CO":
            $valor = 1;
            break;
        case "CA":
            $valor = 2;
            break;
        case "AT":
            $valor = 3;
            break;
        default:
            "";
            break;
    endswitch;

    return $valor;
}

/*
    Retorna fragmento de nome do paciente
*/
function FragmentoNome($palavra)
{

    $ex = explode(" ", $palavra);

    //return $ex[0]." ".$ex[1];
    return $ex[0];
}

/*
    Auditoria de registros sobre usuários
*/
function AuditoriaRegistro($conexao, $tabela, $registro)
{

    $auditoria = "";

    if ($tabela != '' && $registro != '') {

        $rs_auditoria = mysqli_query($conexao, "SELECT usuario, cadastro, atualizacao, usuario_atualizacao FROM $tabela WHERE id='$registro'");

        if (mysqli_num_rows($rs_auditoria) > 0) {

            $row_auditoria = mysqli_fetch_assoc($rs_auditoria);

            if ($row_auditoria['usuario'] != '') {

                $rs_usu_cadastro = mysqli_query($conexao, "SELECT nome FROM usuario WHERE id='" . $row_auditoria['usuario'] . "'");
                $row_usu_cadastro = mysqli_fetch_assoc($rs_usu_cadastro);

                $auditoria .= "Cadastrado por: " . $row_usu_cadastro['nome'] . " em " . date("d/m/Y H:i", strtotime($row_auditoria['cadastro']));
            }

            if ($row_auditoria['usuario_atualizacao'] != '') {

                $rs_usu_atualizacao = mysqli_query($conexao, "SELECT nome FROM usuario WHERE id='" . $row_auditoria['usuario_atualizacao'] . "'");
                $row_usu_atualizacao = mysqli_fetch_assoc($rs_usu_atualizacao);

                $auditoria .= (($auditoria != '') ? '<br />' : '') . "Atualizado por: " . $row_usu_atualizacao['nome'] . " em " . date("d/m/Y H:i", strtotime($row_auditoria['atualizacao']));
            }
        }
    }

    return $auditoria;
}

function GetIp()
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

/*
    Quantidade de dias entre datas
*/
function DiasEntreDatas($data_ini, $data_fim)
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


/*
    Disparo de endpoints para api
*/
function CURL_API($METODO, $HEADERS = array(), $DADOS, $ENDPOINT)
{
    // echo $ENDPOINT;

    $curl = curl_init();

    curl_setopt_array($curl, [
        // CURLOPT_PORT => ,
        CURLOPT_URL => $ENDPOINT,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => $METODO,
        CURLOPT_POSTFIELDS => $DADOS,
        CURLOPT_HTTPHEADER => $HEADERS,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_SSL_VERIFYHOST => 0,
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        return "cURL Error #:" . $err;
    } else {
        return json_decode($response, true);
    }
}
