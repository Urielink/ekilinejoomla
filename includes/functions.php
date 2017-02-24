<?php
	// Función: verifica que la imagen sea absoluta o relativa y la convierte absoluta
	function getAbsoluteImageUrl($pageUrl,$imgSrc)
	{
		$imgInfo = parse_url($imgSrc);
		if (! empty($imgInfo['host'])) {
			//img src ya tiene una ruta absoluta
			return $imgSrc;
		}
		else {
			$urlInfo = parse_url($pageUrl);
			$base = $urlInfo['scheme'].'://'.$urlInfo['host'];
			if (substr($imgSrc,0,1) == '/') {
				//img src es relativa a la url raíz
				return $base . $imgSrc;
			}
			else {
				//img src es relativa del directorio
				return
				$base
				. substr($urlInfo['path'],0,strrpos($urlInfo['path'],'/'))
				. '/' . $imgSrc;
			}
		}
	}	
	/* $imgfull = getAbsoluteImageUrl($host,$timage);*/
 
?>