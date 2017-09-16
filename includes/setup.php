<?php
/** Invoca el core con estas 3 primeras variables:
 * 1. Para añadir las opciones del template
 * 2. Cambiar/Añadir librerías css y js
 * 3. Añadir scripts, metas y links en orden acorde a <jdoc:include>
 * 4. Simplificar rutas de items
 * 5. Enriquecer el código y simplificarlo 
 **/

$app = JFactory::getApplication();
$doc = JFactory::getDocument();
$user = JFactory::getUser();
$config = JFactory::getConfig();
$input = JFactory::getApplication()->input;
$host = JURI::base();
$currentUrl = JURI::current();


/* obten el nombre del componente: 
 * https://docs.joomla.org/Retrieving_request_data_using_JInput 
 */
$componentname = $input->get('option');
$componentname = explode("_",$componentname);

/* obten el nombre de la vista y el ID del objeto
 * http://stackoverflow.com/questions/17769409/how-to-get-current-page-parameters-and-properties-of-joomla-3-1
 */
$view = $input->get('view');
$id = $input->getInt('id');

/* para extraer la informacion del articulo:
 * http://stackoverflow.com/questions/22070139/access-joomla-3-2-article-title-from-the-module-displayed-alongside
*/
//ID de item
$article = JTable::getInstance('content');
// $article->load($id);

/*
 * para extraer la información de la categoría, 
 * A) Prueba con la base de datos: http://stackoverflow.com/questions/8928967/display-category-name-in-template
 * B) Mejor con el método de los artículos
 * C) Con la clave apra categorias: 
 * http://stackoverflow.com/questions/27627607/joomla-3-adding-category-image-in-article-template
 * https://api.joomla.org/cms-3/classes/JCategories.html
 */
//$category = JTable::getInstance('category');
//$category->load($id);
$category = JCategories::getInstance('content')->get($id);

// Acorta la url del template.
$tpath = $this->baseurl.'/templates/'.$this->template;

// Añade las metas de bootstrap
$doc->setMetaData( 'viewport', 'width=device-width, initial-scale=1' );

// Añade los estilos CSS bootstrap
$doc->addStyleSheet($tpath . '/css/bootstrap.min.css');
$doc->addStyleSheet($tpath . '/css/ie10-viewport-bug-workaround.css');
// Añade el estilo del template
$doc->addStyleSheet($tpath . '/css/template.css');

/** 10 de septiembre, si el usuario es invitado reemplaza los scripts **/
if($user->guest){
    // Deshabilita los scripts que no necesito: bootstrap de joomla.
    JHtml::_('bootstrap.framework', false);
    //dehabilitar el framework.bootstrap de joomla
    unset($doc->_scripts[JURI::root(true).'/media/jui/js/bootstrap.min.js']);
    // Añade los js de bootstrap (requiere este orden)
    $doc->addScript($tpath.'/js/bootstrap.min.js');
    $doc->addScript($tpath.'/js/ie10-viewport-bug-workaround.js');
}

// Añadir librerias auxiliares de template (requiere este orden)
$doc->addScript($tpath.'/js/jquery.lazyload.js');


/** Añade una clase CSS por cada item de menu o por clase añadida por usuario
 *  https://docs.joomla.org/Using_the_Page_Class_Suffix_in_Template_Code
 *  http://forum.joomla.org/viewtopic.php?t=270141 
 *  https://docs.joomla.org/Retrieving_request_data_using_JInput
 *  http://joomla.stackexchange.com/questions/4445/how-to-get-article-intro-image-by-article-id
 */


$menu = $app->getMenu()->getActive();
$pageclass = '';
 
if (is_object($menu)){
	$pageclass = $menu->params->get('pageclass_sfx');
	$pageclass = $pageclass ? htmlspecialchars($pageclass) : 'default ';
	$pageclass = $pageclass . ' ' . htmlspecialchars($menu->alias) . ' ' . $view .' '.$componentname[1];
}


/**
 * Redes sociales:
 * G+ Schema
 * Twitter Card
 * FB OG 
 */

if ($view == 'category' && $componentname[1] == 'content'){

	// Variables
	$metaType = 'website';
	$metaTitle = $category->get('title');
	$categoryDescription = $category->get('description');
		$metaDescription = JFilterOutput::cleanText($categoryDescription);
	$categoryImage = $category->getParams()->get('image');
		$metaImages = $host.$categoryImage;	
	} 

elseif ($view == 'article'){
	
	// Variables 
	$metaType = 'article';
	$metaTitle = $article->get('title');
		$articleIntro = $article->get('introtext');
	$metaDescription = $doc->getMetaData('description');
	//http://www.eighttwentydesign.com/blog/all/149-how-to-get-article-s-intro-image-in-joomla-using-php
	$articleImage = $article->get('images');
		$picture = json_decode($articleImage);
		
	// Busca la imagen en los espacios reservados si no está extraer de artículo.
	if (($picture->image_intro))
	{
		$metaImages = $host.$picture->image_intro;
	}
	elseif   (($picture->image_fulltext))
	{
		$metaImages = $host.$picture->image_fulltext;
	}
	else
	{
		// Extraccion de imagen preg_match busca las etiquetas de imagen aqui en el texto.
		preg_match('/<img (.*?)>/', $articleIntro, $match);
		// dame la primera
		$imagen = $match[0];
		// dame la url del SRC
		$imgurl = preg_replace('#.*src="([^\"]+)".*#', '\1', $imagen);
		// genera la URL
		$timage = htmlspecialchars($imgurl);
		// ../function.php para verificar que es correcto.
		$metaImages = getAbsoluteImageUrl($host,$timage);
	}	
} 
else {

	// Variables
	$metaType = 'article';
	$metaTitle = htmlspecialchars($menu->title);
	$metaDescription = htmlspecialchars($doc->getMetaData('description'));
	$metaImages = $host . 'templates/' . $this->template . '/template_preview.png';
}

?>
