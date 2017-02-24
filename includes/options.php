<?php
// Invoca las opciones de template: https://docs.joomla.org/Understanding_Joomla!_templates
$templateparams = $app->getTemplate(true)->params;

/** Variables en las opciones de template Bixnia **/

/*Layout*/
$fluidContainer = $templateparams->get('fluidContainer');
$leftColumn = (int) $templateparams->get('leftCol', 0);
$comColumn = (int) $templateparams->get('comCol', 0);
$rightColumn = (int) $templateparams->get('rightCol', 0);

/*Diseño*/
$logo = $templateparams->get('logo');

$backgroundimage = $templateparams->get('backgroundimage');
$bkgimglayout = $templateparams->get('bkgimglayout', 0);
$bkgcolor = $templateparams->get('bkgcolor');
$headerbkgcolor = $templateparams->get('headerbkgcolor');
$footerbkgcolor = $templateparams->get('footerbkgcolor');
$textcolor = $templateparams->get('textcolor');
$fontsheading = $templateparams->get('fontsheading');
$fontscontent = $templateparams->get('fontscontent');


/*Optimización*/
$tagGplus = $templateparams->get('taggplus');
$tagTcard = $templateparams->get('tagtcard');
$tagFbograph = $templateparams->get('tagfbograph');

$wmtools = $templateparams->get('wmtools');
$bing = $templateparams->get('bing');
$pinterest = $templateparams->get('pinterest');
$appfb = $templateparams->get('appfacebook');
$analytics = $templateparams->get('analytics');
$gtagmanage = $templateparams->get('gtagmanage');

/*Enviar scripts al final*/
$jstoend = $templateparams->get('jstoend');

/**
 * Métodos para ingresar las metas directo en joomla header.
 */
 
/*Metas en head: https://docs.joomla.org/JDocument/setMetaData */
if ($wmtools != null ): $doc->setMetaData( 'google-site-verification', $wmtools ); endif;
if ($bing != null ): $doc->setMetaData( 'msvalidate.01', $bing ); endif;
if ($pinterest != null ): $doc->setMetaData( 'p:domain_verify', $pinterest ); endif;
/*Otro tipo de etiquetas: http://forum.joomla.org/viewtopic.php?f=712&t=786152*/
if ($appfb != null ): $doc->addCustomTag( '<meta property="fb:app_id" content="'.$appfb.'"/>'); endif;

/** En caso de habilitar los tags de socialmedia en optimización: **/

if ($tagGplus == '1') {
	$doc->addCustomTag( '
		<meta itemprop="name" content="'.$metaTitle.'">
		<meta itemprop="description" content="'.$metaDescription.'">
		<meta itemprop="image" content="'.$metaImages.'">
		');
}

if ($tagTcard == '1') {
	$doc->addCustomTag( '
		<meta name="twitter:card" content="summary">
		<meta name="twitter:site" content="@loshijosdelrol">
		<meta name="twitter:title" content="'.$metaTitle.'">
		<meta name="twitter:description" content="'.$metaDescription.'">
		<meta name="twitter:creator" content="@loshijosdelrol">
		<meta name="twitter:image" content="'.$metaImages.'">
		');
}

if ($tagFbograph == '1') {
	$doc->addCustomTag( '
		<meta property="og:title" content="'.$metaTitle.'"/>
		<meta property="og:type" content="'.$metaType.'"/>
		<meta property="og:url" content="'.$currentUrl.'"/>
		<meta property="og:image" content="'.$metaImages.'"/>
		<meta property="og:description" content="'.$metaDescription.'"/>
		<meta property="og:site_name" content="'.htmlspecialchars($config->get( 'sitename' )).'"/>
		<meta property="fb:admins" content="urielink.pinlazk"/>
		');
}

// En caso de querer que estos scripts vayan en el head: 
if ($jstoend != '1') {
    
    // analytics esta versión va directo en el head: https://docs.joomla.org/JDocument/addScriptDeclaration
    if ($analytics != null ){
    $script	 = "
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
      ga('create', '" . htmlspecialchars($analytics) . "', 'auto');
      ga('require', 'displayfeatures');		
      ga('send', 'pageview');
      ";
    	
    // Se debe añadir como etiqueta independiente no como scriptDeclaration
    	$doc->addCustomTag('<script type="text/javascript">'.$script.'</script>');
    }
    
    // Añade archivo js del template (requiere este método para aparecer al final), 18ago: hay un error en anlytics.
    $doc->addCustomTag('<script src="'. $tpath.'/js/plugins.js" type="text/javascript"></script>');
    
} elseif ($jstoend == '1') {
        
     // En caso de querer que estos scripts vayan en el footer: 
     // AGo 07 2016 : UPDATE, existe un error al invocarlo como declaración directa.
        
/**    if ($analytics != null ){      
    $doc->addScriptDeclaration("
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
      ga('create', '" . htmlspecialchars($analytics) . "', 'auto');
      ga('require', 'displayfeatures');     
      ga('send', 'pageview');
      ");         
    }    
    
    // Añade archivo js del template (requiere este método para aparecer al final), 18ago: hay un error en anlytics.
    $doc->addScript($tpath.'/js/plugins.js'); **/
        
    // probamos mejor guardarlo como una variable
    
    if ($analytics != null ){
    $script = "
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
        ga('create', '" . htmlspecialchars($analytics) . "', 'auto');
        ga('require', 'displayfeatures');     
        ga('send', 'pageview');
    ";
        
    // variable de analytics y script del template para aparecer al final
    $analyticsBottom = '
    <script type="text/javascript">'.$script.'</script>
    <script src="'. $tpath.'/js/plugins.js" type="text/javascript"></script>
    ';
    }            
        
}


// Ocupar google tag manager directo en el head del template
if ($gtagmanage != null ): $gtagmanage; endif;


/**
 * Métodos para establecer el layout del sitio, 1, 2 o 3 columnas.
 * Estático al centro y fluido.
 */

/* Layout: en caso de contenedor fluido*/
if ($fluidContainer == '1' ): $fluidContainer = 'container-fluid'; elseif ($fluidContainer == '0' ) : $fluidContainer = 'container'; endif;

/* Variables para el ancho de Layout */

/**En caso de tener 3 columnas ocupadas, o solo ocupar 2, establece el ancho de cada columna que se genera en las opciones y encierralas en un row **/
 if ($this->countModules('aside-left') && $this->countModules('aside-right'))
 {
	$leftWidth    = $leftColumn != 0 ? 'col-md-' . $leftColumn : '';
	$comWidth    = $comColumn != 0 ? 'col-md-' . $comColumn : '';
	$rightWidth    = $rightColumn != 0 ? 'col-md-' . $rightColumn : ''; 	
 }
elseif ($this->countModules('aside-left') && !$this->countModules('aside-right'))
 {
	$leftWidth    = $leftColumn != 0 ? 'col-md-' . $leftColumn : '';
	$comWidth    = $comColumn != 0 ? 'col-md-' . ($comColumn + $rightColumn) : '';
 }
elseif (!$this->countModules('aside-left') && $this->countModules('aside-right'))
 {
	$comWidth    = $comColumn != 0 ? 'col-md-' . ($comColumn + $leftColumn) : '';
	$rightWidth    = $rightColumn != 0 ? 'col-md-' . $rightColumn : ''; 	
 }
elseif (($comColumn + $rightColumn + $leftColumn)!='12')
 {
	$comWidth    = $comColumn != 0 ? 'col-md-' . ($comColumn + $rightColumn + $leftColumn) : '';
 }
else{
	$comWidth    = 'row';
}
 
/**En caso de tener 2 o 3 columnas crea un row para contenerlas **/
 if ($this->countModules('aside-left') && $leftColumn != 0 || $this->countModules('aside-right') && $rightColumn != 0)
 { 
 	$rowOpen = '<div class="row">'; 
 	$rowClose = '</div>';
 }

 /**
  * Métodos para el diseño del sitio
  * Imagenes de background y colores.
  * (Design)
  */

if ($backgroundimage != null ) : $backgroundimage = 'background-image:url("/' . $backgroundimage . '");'; endif;

$estiloCss = array(
		'0' => 'background-size:100% auto;background-attachment:fixed;background-repeat:no-repeat;',
		'1' => 'background-position:left top;background-repeat:repeat;',
		'2' => 'background-position:center top;background-repeat:repeat-x;',
		'3' => 'background-position:center top;background-repeat:no-repeat;',
		'4' => '');

$bkgimglayout = $estiloCss[$bkgimglayout];

$bkgcolor = 'background-color:' . $bkgcolor . ';';
$textcolor = 'color:' . $textcolor . ';';
$headerbkgcolor = 'header{background-color:' . $headerbkgcolor . ';}';
$footerbkgcolor = 'footer{background-color:' . $footerbkgcolor . ';}';

$style = 'body{'.$backgroundimage.$bkgimglayout.$bkgcolor.$textcolor.'}'.$headerbkgcolor.$footerbkgcolor;
	$doc->addStyleDeclaration( $style );

	
/**
 * Google fonts
 */	
	
if ($fontsheading != null ){
	$href = 'https://fonts.googleapis.com/css?family='.htmlspecialchars($fontsheading);
	$attribs = array('type' => 'text/css');
	// añadir link al head: https://docs.joomla.org/JDocumentHTML/addHeadLink
	$doc->addHeadLink( $href, 'stylesheet', 'rel', $attribs );
		//Extraer el nombre de la fuente http://stackoverflow.com/questions/28507459/extract-font-name-and-display-with-quotation-mark
		$font = '\'' . str_replace ('+', ' ', substr (htmlspecialchars($fontsheading) , 0, strpos (htmlspecialchars($fontsheading), ':'))) . '\'';
		$doc->addStyleDeclaration( 'h1,h2,h3,h4,h5,h6{font-family:'.$font.';}' );
}
if ($fontscontent != null ){
	$href = 'https://fonts.googleapis.com/css?family='.htmlspecialchars($fontscontent);
	$attribs = array('type' => 'text/css');
	$doc->addHeadLink( $href, 'stylesheet', 'rel', $attribs );
		$font = '\'' . str_replace ('+', ' ', substr (htmlspecialchars($fontscontent) , 0, strpos (htmlspecialchars($fontscontent), ':'))) . '\'';
		$doc->addStyleDeclaration( 'body{font-family:'.$font.';}' );
}
	

/** Dividir el contenido en head: http://joomla.stackexchange.com/questions/4772/joomla-templating-custom-jdoc-statements **/
if ($jstoend == '1') {
//	require_once('templates/'.$this->template.'/includes/head.php');
//	require_once('templates/'.$this->template.'/includes/scripts.php');
	require_once('head.php');
	require_once('scripts.php');
	$endScripts = '<jdoc:include type="scripts" />' . $analyticsBottom ;
}
?>