<?php

error_reporting(E_ALL);

/**********
/* Função de processamento e gravação de imagens
/* escopo de variáveis
/* $imagem - $_FILES['imagem'] - Não passar array - Manipular o array no arquivo de origem (ações)
/* 
/* $largura - array com as larguras (width) que a imagem será definida - ex.: $largura = array(1800,960,192);
/* 
/* $altura - array com as alturas (height) que a imagem será definida - ex.: $altura = array(1200,540,108);
/* 
/* $caminho - array com os caminhos (path) onde as imagens processadas serão gravadas
/* 
/* $crop - array informando se alguma imagem será cropada - ex.: $crop = array(0,1,0);
/* No exemplo acima, somente a segunda imagem será cropada
/* Definir o corte nas variáveis $largura e $altura (nesse exemplo, a imagem será cropada com 960x540)
/* 
/* $pb - array informando se alguma imagem será convertida para PB (greyscale) - ex.: $pb = array(0,0,1);
/* No exemplo acima, somente a última imagem será convertida para PB
/* 
/* $seo_nome - redefine o nome da imagem - ex.: $seo = "cat_produto-nome_produto";
/* Se já houver uma imagem com o mesmo nome, a função redefinirá automaticamente o nome adicionando um número auto-incrementado a ele
/* Nesse exemplo, seria renomeado para cat_produto-nome_produto-1, cat_produto-nome_produto-2 e assim sucessivamente
/* Se $seo_nome não for passado, a função usará o nome original da imagem.
/* 
/* ----- Marca d'água (watermark) -----
/* As variáveis $watermark, $tipo_watermark, $pos_watermark são para gerar uma imagem com marca d'água
/* 
/* $watermark - pode ser uma imagem ou um texto. Se for imagem, deve ser passado o caminho absoluto da imagem
/* 
/* $tipo_watermark - o tipo da marca d'água - usar "t" ou "i" - (t)exto ou (i)magem 
/* 
/* $pos_watermark - posição da marca d'água - usar "T", "C" ou "B" - (T)op, (C)enter, (B)ottom
/* "TL", "TR", "CL", "CR", "BL" ou "BR" também são aceitos - use (L)eft para alinhar a esquerda ou (R)ight para alinhar a direita
/* 
/* As variáveis para uso de marca d'água não são obrigatórias, mas se $watermark for setada, $tipo_watermark deverá ser preenchida,
/* caso contrário, será considerado tipo texto, por padrão
/* 
/* para textos com acentuação usar utf8_decode - ex.: utf8_decode("Benetton Comunicação")
/*
**********/
function salvaimagem($imagem, $largura, $altura, $caminho, $crop, $pb, $seo_nome = "", $watermark = "", $tipo_watermark = "", $pos_watermark = "")
{
	include_once('../src/class.upload.php');
	$handle = new Upload($imagem);
	if ($handle->uploaded)
	{
		if($seo_nome)//redefine o nome da imagem
			$handle->file_src_name_body = $seo_nome;
		$nome_arquivo = "";
		//Se foi feito o upload, percorrer o array para salvar as imagens
		foreach($largura as $i => $v)
		{
			$handle->image_resize			= true;
			if($crop[$i])
				$handle->image_ratio_crop	= true;
			else
				$handle->image_ratio		= true;			
			$handle->image_y				= $altura[$i];
			$handle->image_x				= $v;
			if($pb[$i])
				$handle->image_greyscale	= true;

			if($watermark)
			{
				if($tipo_watermark == "i") //a marca d'água é uma imagem
				{
					$handle->image_watermark = $watermark;
					$handle->image_watermark_position = $pos_watermark ? $pos_watermark : "B";//se não for setado, usar bottom para prevenir erros de processamento de imagem
				}
				else //é um texto
				{
					$handle->image_text = $watermark;
					$handle->image_text_background = '#000000';
					$handle->image_text_background_opacity = 50;
					$handle->image_text_padding    = 5;
					$handle->image_text_position   = $pos_watermark ? $pos_watermark : "B";//se não for setado, usar bottom para prevenir erros de processamento de imagem
				}
			}

			//processar a imagem
			$handle->Process($caminho[$i]);
			if($handle->processed)
				$nome_arquivo = $handle->file_dst_name;		}
		$handle-> Clean();
		return $nome_arquivo;		
	}
	else
		return false;
	
}

$tam = getimagesize($_FILES['my_field']['tmp_name']);
$lar = $tam[0];//Largura da imagem original
$alt = $tam[1];//Altura da imagem original

$largura 	= array($lar,960,192);
$altura 	= array($alt,540,108);
$caminho 	= array("tmp/original/","tmp/large/","tmp/thumb/");
$crop 		= array(0,1,0);//Se uma imagem precisa ser cropada, definir o corte nas variáveis $largura e $altura (nesse exemplo, a imagem será cropada com 960x540)
$pb 		= array(0,1,1);
$seo = "teste-upload-imagem";
$watermark = utf8_decode("Benetton Comunicação - ");
$tipo_watermark = "t";
$pos_watermark = "BL";
	
echo $foto1 = salvaimagem($_FILES["my_field"], $largura, $altura, $caminho, $crop, $pb, $seo, $watermark, $tipo_watermark, $pos_watermark);
