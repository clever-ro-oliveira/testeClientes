<?php @date_default_timezone_set('America/Sao_Paulo');
function busca_foto($id_fb, $tamanho = 250)
{
	$ch = curl_init();
	curl_setopt ($ch, CURLOPT_URL, 'https://graph.facebook.com/'.$id_fb.'?fields=picture.width('.$tamanho.').height('.$tamanho.')');
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 0);
	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
	$file_contents = curl_exec($ch);
	curl_close($ch);
	$json = json_decode($file_contents, true);
	$foto = $json["picture"]["data"]["url"];
	return $foto;
}

function formaNomeArquivo($string) {
	$string = iconv( "UTF-8" , "ASCII//TRANSLIT//IGNORE" , strtolower( trim( strip_tags( htmlspecialchars_decode( tira_acento( filtro( "string",$string ) ) ) ) ) ) ); 
	$string = strtr($string," ","-");
	$string = strtr($string,"_","-");
	$string = preg_replace( array( '/[ ]/' , '/[^A-Za-z0-9\-.]/' ) , array( '' , '' ) , $string );
	return $string;
}

function mostra_array($array){
	echo "<pre>";
	print_r($array);
	echo "</pre>";
}

function removeEspaco($arquivo)
{
	$array1 = array(" ", "·", "‡", "‚", "„", "‰", "È", "Ë", "Í", "Î", "Ì", "Ï", "Ó", "Ô", "Û", "Ú", "Ù", "ı", "ˆ", "˙", "˘", "˚", "¸", "Á", "¡", "¿", "¬", "√", "ƒ", "…", "»", " ", "À", "Õ", "Ã", "Œ", "œ", "”", "“", "‘", "’", "÷", "⁄", "Ÿ", "€", "‹", "«", "-" );
	$array2 = array("_", "a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c", "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C", "_" );
		
	return $arquivo = str_replace( $array1, $array2, $arquivo);

}

function tira_acento($palavra)
{
	$array1 = array("&rsquo;", "&aacute;", "&agrave;", "&acirc;", "&atilde;", "&auml;", "&eacute;", "&egrave;", "&ecirc;", "&euml;", "&iacute;", "&igrave;", "&icirc;", "&iuml;", "&oacute;", "&ograve;", "&ocirc;", "&otilde;", "&ouml;", "&uacute;", "&ugrave;", "&ucirc;", "&uuml;", "&ccedil;", "&Aacute;", "&Agrave;", "&Acirc;", "&Atilde;", "&Auml;", "&Eacute;", "&Egrave;", "&Ecirc;", "&Euml;", "&Iacute;", "&Igrave;", "&Icirc;", "&Iuml;", "&Oacute;", "&Ograve;", "&Ocirc;", "&Otilde;", "&Ouml;", "&Uacute;", "&Ugrave;", "&Ucirc;", "&Uuml;", "&Ccedil;", "&ordm;", "&ordf;" );
	$array2 = array("", "a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c", "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C", "o", "a" );
		
	return $palavra = str_replace( $array1, $array2, $palavra);

}

function forma_url($string) {
	$string = iconv( "UTF-8" , "ASCII//TRANSLIT//IGNORE" , trim(strip_tags(htmlspecialchars_decode(tira_acento($string)))) );
	$string = strtr($string," ","-");
	$string = preg_replace( array( '/[ ]/' , '/[^A-Za-z0-9\-]/' ) , array( '' , '' ) , $string );
	return strtolower( $string );
}

function limpa_nome($string) {
	$string = iconv( "UTF-8" , "ASCII//TRANSLIT//IGNORE" , htmlspecialchars_decode(tira_acento($string)) );
	$string = strtr($string,"-","");
	$string = strtr($string," ","-");
	$string = preg_replace( array( '/[ ]/' , '/[^A-Za-z0-9\-]/' ) , array( '' , '' ) , $string );
	$string = strtr($string,"-"," ");
	return $string;
}

function limitaTexto($string, $word_limit) 
{   
	$tags = array("[imagem]", "[galeria]", "[video]");
	$string = str_replace($tags,"",strip_tags($string));
	$words = explode(' ', $string); 
	$ret = "";
	if(count($words) > $word_limit)
		$ret = "...";
	return implode(' ', array_slice($words, 0, $word_limit)).$ret;
}

function seg_login($v)
{
    $valor = addslashes($v);
    $array2 = array("/\bDELETE\b/i","/\bUPDATE\b/i","/\bINSERT\b/i","/\bDROP\b/i","/\bSELECT\b/i","/\bSET\b/i","/\bINTO\b/i","/\bWHERE\b/i","/'/","/\bOFFSET\b/i","/\bJOIN\b/i","/\bUNION\b/i","/\bCONCAT\b/i","/\bLIMIT\b/i","/\bALERT\b/i","/\bLEFT\b/i","/\bINNER\b/i","/\bNOT\b/i","/\bLIKE\b/i","/\bTRUNCATE\b/i","/\bALTER\b/i","/\bDELIMITER\b/i","/\bAND\b/i","/\bSLEEP\b/i","/\bCONFIRM\b/i","/\bDBMS\b/i","/\bDBMS_LOCK\b/i","/\bDBMS_LOCK.SLEEP\b/i","/\bWAITFOR\b/i","/\bDELAY\b/i","/\bCENZICMARKER\b/i","/\bCENZICBENIGN\b/i","/\bNULL\b/i");
    $valor = str_replace('"',"&quot;",$valor);
    $valor = str_replace("'","&rsquo;",$valor);
    $valor = preg_replace($array2,"",$valor);
    return($valor);
}

function seguranca($valor)
{
	$valor = addslashes($valor);
	$valor = str_replace('"',"&quot;",$valor);
	$valor = str_replace("'","&rsquo;",$valor);
	return $valor;
}

function retorna_form($post){
	$names = array_keys($post);
	$form = array();
	foreach($names as $n){
		if(gettype($post[$n]) == "string")
			$form[$n] = seguranca($post[$n]);
		elseif(gettype($post[$n]) == "array")
			$form[$n] = retorna_form($post[$n]);
		else
			$form[$n] = $post[$n];
	}
	return($form);
}

function geraSenha($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false)
{
	$lmin = 'abcdefghijklmnopqrstuvwxyz';
	$lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$num = '1234567890';
	$simb = '!@#$%*-';
	$retorno = '';
	$caracteres = '';
	
	$caracteres .= $lmin;
	if ($maiusculas) $caracteres .= $lmai;
	if ($numeros) $caracteres .= $num;
	if ($simbolos) $caracteres .= $simb;
	
	$len = strlen($caracteres);
	for($n = 1; $n <= $tamanho; $n++)
	{
		$rand = mt_rand(1, $len);
		$retorno .= $caracteres[$rand-1];
	}
	return $retorno;
}

function redireciona($valor)
{
	echo "<script>window.location='".$valor."';</script>";
}
 
function salvaimagem($imagem, $largura, $altura, $caminho, $crop, $pb, $seo_nome = "", $watermark = "", $tipo_watermark = "", $pos_watermark = "", $opacity = array() )
{
	error_reporting(E_ALL);
	ini_set('memory_limit', '2048M');
	ini_set('max_execution_time', 0);
	include_once('classe_imagem/src/class.upload.php');
	$handle = new Upload($imagem);
	if ($handle->uploaded)
	{
		if($seo_nome)//redefine o nome da imagem
			$handle->file_src_name_body = forma_url( $seo_nome );
		$nome_arquivo = "";
		//Se foi feito o upload, percorrer o array para salvar as imagens
		foreach($largura as $i => $v)
		{
			$handle->image_resize			= true;
			if(@$crop[$i])
				$handle->image_ratio_crop	= true;
			else
				$handle->image_ratio		= true;			
			$handle->image_y				= $altura[$i];
			$handle->image_x				= $v;
			if($pb[$i])
				$handle->image_greyscale	= true;
			if(@$opacity[$i])
				$handle->image_opacity		= $opacity[$i];

			if($watermark)
			{
				if($tipo_watermark == "i") //a marca d'·gua È uma imagem
				{
					$handle->image_watermark = $watermark;
					$handle->image_watermark_position = $pos_watermark ? $pos_watermark : "B";//se n„o for setado, usar bottom para prevenir erros de processamento de imagem
				}
				else //È um texto
				{
					$handle->image_text = $watermark;
					$handle->image_text_background = '#000000';
					$handle->image_text_background_opacity = 50;
					$handle->image_text_padding    = 5;
					$handle->image_text_position   = $pos_watermark ? $pos_watermark : "B";//se n„o for setado, usar bottom para prevenir erros de processamento de imagem
				}
			}

			//processar a imagem
			$handle->Process($caminho[$i]);
			if($handle->processed)
				$nome_arquivo = $handle->file_dst_name;
		}
		//$handle-> Clean();
		return $nome_arquivo;
	}
	else
		return false;
}

function troca_acentos($texto, $inverso = false)
{
	//$inverso = true - retorna a letra acentuada
	//$inverso = false - retorna o cÛdigo html
	
	$arr_caracteres1 = array('Ω', 'Æ','≥','≤',"ß","∞","∫","™","·", "‡", "‚", "„", "‰", "È", "Ë", "Í", "Î", "Ì", "Ï", "Ó", "Ô", "Û", "Ú", "Ù", "ı", "ˆ", "˙", "˘", "˚", "¸", "Á", "¡", "¿", "¬", "√", "ƒ", "…", "»", " ", "À", "Õ", "Ã", "Œ", "œ", "”", "“", "‘", "’", "÷", "⁄", "Ÿ", "€", "‹", "«","—","Ò");
	
	$arr_caracteres2 = array('&frac12;', '&reg;','&sup3;','&sup2;',"&sect;","&ordm;","&ordm;","&ordf;","&aacute;", "&agrave;", "&acirc;", "&atilde;", "&auml;", "&eacute;", "&egrave;", "&ecirc;", "&euml;", "&iacute;", "&igrave;", "&icirc;", "&iuml;", "&oacute;", "&ograve;", "&ocirc;", "&otilde;", "&ouml;", "&uacute;", "&ugrave;", "&ucirc;", "&uuml;", "&ccedil;", "&Aacute;", "&Agrave;", "&Acirc;", "&Atilde;", "&Auml;", "&Eacute;", "&Egrave;", "&Ecirc;", "&Euml;", "&Iacute;", "&Igrave;", "&Icirc;", "&Iuml;", "&Oacute;", "&Ograve;", "&Ocirc;", "&Otilde;", "&Ouml;", "&Uacute;", "&Ugrave;", "&Ucirc;", "&Uuml;", "&Ccedil;","&Ntilde;","&ntilde;");
	
	if($inverso)
		$valor = str_replace($arr_caracteres2,$arr_caracteres1,$texto);
	else
		$valor = str_replace($arr_caracteres1,$arr_caracteres2,utf8_decode($texto));

	return $valor;
}

function troca($texto)
{
	$arraylixo = array("‚Äì", "¥", "‚Ä¢","‚Äù",'î',"í","‚Äô",'‚Äò',"‚Äú","‚Ä","ì","î","ë","í","\n","ñ","ï","&amp;","\r","&nbsp;");
	$arraytroca = array("&ndash;", "&rsquo;", "&bull;",'&rdquo;','&rdquo;',"&rsquo;","&#039;","&#039;",'&ldquo;','&quot;','&ldquo;','&rdquo;',"&lsquo;","&rsquo;","<br />","-","&bull;","&",""," ");
	$valor = str_replace($arraylixo,$arraytroca,$texto);
	return $valor;
}

function filtro($tipocampo, $valor)
{
	$arraylixo = array( "&quot;&ldquo;", "?&rsquo;", "‚Äù",'‚Ä¶', '√ï','√î','‚Äù','î',"í","‚Äô",'‚Äò',"‚Äú","‚Ä","ì","î","ë","í","\n","ñ","ï","&amp;","\r","&nbsp;");
	$arraytroca = array( "&ndash;", "&rsquo;", "&quot;",'...','&Otilde;','&Ocirc;','&quot;','&quot;',"&#039;","&#039;","&#039;",'&quot;','&quot;','&quot;','&quot;',"&#039;","&#039;","<br />","-","&bull;","&",""," ");

	$array_O1 = array("”", "“", "‘", "’", "÷","Û","Ú","Ù","ı","ˆ");
	$array_O2 = array("√ì","√í","√î","√ï","√ñ","√≥","√≤","√¥","√µ","√∂");
	$array_O = array("&Oacute;", "&Ograve;", "&Ocirc;", "&Otilde;", "&Ouml;","&oacute;", "&ograve;", "&ocirc;", "&otilde;", "&ouml;");

	switch($tipocampo)
	{
		case "string":
		$valor = str_replace($array_O1,$array_O,$valor);
		$valor = str_replace($array_O2,$array_O,$valor);
		$valor = troca($valor);
		$valor = troca_acentos($valor);
		$valor = str_replace($arraylixo,$arraytroca,$valor);
		$valor = htmlentities(utf8_decode($valor), ENT_QUOTES);
		$valor = str_replace($arraylixo,$arraytroca,$valor);
		break;
			
		case "date":
		if($valor != null || $valor != ""){
			$valor = @date("Y-m-d H:i", @strtotime(str_replace("/","-",$valor)));
		}else{
			$valor = "";
		}
		break;
						
		case "num":
		$valor = preg_replace("/\D+/", "", $valor); // remove qualquer caracter n„o numÈrico
		break;
			
		case "float":
		$valor = str_replace(",",".",str_replace(".","",$valor));
		break;
		
		case "url":
		$valor = urldecode($valor);
		break;
		
		case "cond"://condiÁ„o
		$valor = "";
		break;
		
		default:
		$valor = str_replace("\n","<br />",htmlentities(utf8_decode($valor), ENT_QUOTES));
		
	}
	return $valor;
}

function executa( $conexao, $form, $tabela, $acao, $condicao)
{
	$campos = "";
	$valores = "";
	$count = 0;
	if($acao == "inserir")
	{
		foreach($form as $campo => $valor)
		{
			$tipo = explode("-",$campo);
			
			if ($valor != null || $valor != "" || $valor != 0){
			
				if($tipo[1] != 'cond'){

					$valor = filtro($tipo[1],$valor);
				
					if($count != 0)
						$campos .= ", ".$tipo[0]." = '".($valor)."'";
					else
						$campos .= $tipo[0]." = '".($valor)."'";
			  
					$count++;
				}
			}
		}
		$sql = "INSERT INTO $tabela SET $campos";
		$sql = mysqli_query( $conexao, $sql);
		$id = mysqli_insert_id( $conexao );
		return $id;
	}
	else if($acao == "edita")
	{
		foreach($form as $campo => $valor)
		{
			$tipo = explode("-",$campo);
			
			if($tipo[1] != 'cond'){

				$valor = filtro($tipo[1],$valor);

				if($count != 0)
					$campos .= ", ".$tipo[0]." = '".($valor)."'";
				else
					$campos .= $tipo[0]." = '".($valor)."'";
		  
				$count++;
			}
		}
		$sql = "UPDATE $tabela SET $campos WHERE $condicao";
		$sql = mysqli_query( $conexao, $sql);
		return $sql;
	}
}

function lat_long($endereco){
	$endereco = tira_acento($endereco);
    $address = str_replace(' ','+', html_entity_decode( $endereco,ENT_QUOTES) ).',+Brasil';
	echo "https://maps.google.com/maps/api/geocode/json?address=" . $address . "&sensor=false";

    $ch = curl_init();
	curl_setopt($ch,CURLOPT_URL, "https://maps.google.com/maps/api/geocode/json?address='.$address.'&sensor=false");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	$result = curl_exec($ch);
	curl_close($ch);

    $output= json_decode($result);
	mostra_array($output);

    $lat = @$output->results[0]->geometry->location->lat;
    $long = @$output->results[0]->geometry->location->lng;

    $array = array();
    $array[0] = $lat;
    $array[1] = $long;
    return $array;
}

?>
