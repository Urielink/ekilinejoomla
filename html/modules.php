<?php
/**
 * @package		Joomla.Site
 * @copyright	Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

/**
 * This is a file to add template specific chrome to module rendering.  To use it you would
 * set the style attribute for the given module(s) include in your template to use the style
 * for each given modChrome function.
 *
 * eg.  To render a module mod_test in the sliders style, you would use the following include:
 * <jdoc:include type="module" name="test" style="slider" />
 *
 * This gives template designers ultimate control over how modules are rendered.
 *
 * NOTICE: All chrome wrapping methods should be named: modChrome_{STYLE} and take the same
 * two arguments.
 *  
 * Original: ../system/html/modules.php para separar los nombres de las clases
 * para saber más sobre mod_chorme: https://docs.joomla.org/Applying_custom_module_chrome
 * 
 * Para saber los datos de cada modulo: 
 * https://docs.joomla.org/JModuleHelper/getModule
 */
 

/**
 * Contenedor estandard: 
 * Con todas las opciones para ser personalizado
 * 
 **/

function modChrome_Container($module, &$params, &$attribs)
{
	$moduleTag      = $params->get('module_tag', 'div');
	$headerTag      = htmlspecialchars($params->get('header_tag', 'h3'));
	$bootstrapSize  = (int) $params->get('bootstrap_size', 0);
	$moduleClass    = $bootstrapSize != 0 ? ' col-md-' . $bootstrapSize : '';

	// Temporarily store header class in variable
	$headerClass    = $params->get('header_class');
	$headerClass    = !empty($headerClass) ? ' class="' . htmlspecialchars($headerClass) . '"' : '';
	
	// En caso de no tener clase, usa container
	$containerClass    = $params->get('moduleclass_sfx');
	$containerClass    = !empty($containerClass) ? htmlspecialchars($containerClass) : ' container-fluid';
		

    if (!empty ($module->content)) : ?>
        <<?php echo $moduleTag; ?> class="moduletable<?php echo $containerClass . $moduleClass; ?>">

	        <?php if ((bool) $module->showtitle) :?>
            <div<?php echo $headerClass;?>><<?php echo $headerTag . '>' . $module->title; ?></<?php echo $headerTag; ?>></div>
	        <?php endif; ?>

            <?php echo $module->content; ?>

        </<?php echo $moduleTag; ?>>

    <?php endif;
}


/**
 * Contenedor basado en .panel
 * También con todas las opciones habilitadas
 *
 */

function modChrome_Panel($module, &$params, &$attribs)
{
	$moduleTag      = $params->get('module_tag', 'div');
	$headerTag      = htmlspecialchars($params->get('header_tag', 'h3'));
	$bootstrapSize  = (int) $params->get('bootstrap_size', 0);
	$moduleClass    = $bootstrapSize != 0 ? ' col-md-' . $bootstrapSize : '';

	// Temporarily store header class in variable
	$headerClass	= $params->get('header_class');
	$headerClass	= !empty($headerClass) ? ' class="panel-title ' . htmlspecialchars($headerClass) . '"' : '';

	if (!empty ($module->content)) : ?>
		<<?php echo $moduleTag; ?> class="<?php echo htmlspecialchars($params->get('moduleclass_sfx')) . $moduleClass; ?>">

		<div class="panel panel-default">
		
			<?php if ((bool) $module->showtitle) :?>
			<div class="panel-heading">
				<<?php echo $headerTag . $headerClass . '>' . $module->title; ?></<?php echo $headerTag; ?>>
			</div>	
			<?php endif; ?>
			
			<div class="panel-body" >
				<?php echo $module->content; ?>
			</div>

		</div>
		
		</<?php echo $moduleTag; ?>>

	<?php endif;
}


/**
 * Contenedor para navbar:
 * Lista con Link y dropdown.
 */

function modChrome_NavLinkDropdown($module, &$params, &$attribs)
{	
    if (!empty ($module->content)) : ?>
        <ul class="nav navbar-nav navbar-left<?php echo $params->get('moduleclass_sfx'); ?>">
          <li class="dropdown">
            <a class="dropdown-toggle" href="#" data-toggle="dropdown" href="#"><?php echo $module->title;?><span class="caret"></span></a>
            <div class="dropdown-menu" style="padding:15px;min-width:240px;">
                <?php echo $module->content; ?>
            </div>
          </li>
        </ul>
    <?php endif;        
}

/**
 * Contenedor para navbar:
 * Lista con boton y dropdown.
 */

function modChrome_NavBtnDropdown($module, &$params, &$attribs)
{
    if (!empty ($module->content)) : ?>
	<ul class="nav navbar-nav navbar-left<?php echo $params->get('moduleclass_sfx'); ?>">
		<li class="btn-group navbar-btn">
			<button data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><?php echo $module->title;?> <span class="caret"></span></button>
			<div class="dropdown-menu" style="padding:15px;min-width:240px;">
                <?php echo $module->content; ?>
			</div>
		</li>
	</ul>
    <?php endif;        
}


/** 
 * Contenedor basado en la clase .modal para nav bar
 * Agrega un ID para diferenciar varios modulos 
 **/

function modChrome_NavBtnModal($module, &$params, &$attribs)
{
	// Necesitamos saber si el usuario es visitante para añadir una acceso a cerrar sesión directamente.
	$user = JFactory::getUser();
	/**
	 * 1) Si el usiario es visitante muestra la información del modulo de manera normal.
	 * 2) Pero si el usuario está logeado y
	 * 	2a) El modulo es de mod_login muestra un boton para cerrar sesión.
	*/

    if (!empty ($module->content)) : ?>

	<?php if ($user->guest) {
			echo '<button class="btn btn-primary navbar-btn navbar-left'. htmlspecialchars($params->get('moduleclass_sfx')) .'" data-toggle="modal" data-target="#modModal-'. $module->id .'">'. $module->title .' <span class="caret"></span></button>';       
		} else {
    		if($module->module == 'mod_login'){
	        	echo '<a class="btn btn-link navbar-btn navbar-left" href="'. JURI::base() .'index.php?option=com_users&task=user.logout&'. JSession::getFormToken() .'=1">Salir <small class="glyphicon glyphicon-off"></small></a>';
        	} else {
				echo '<button class="btn btn-primary navbar-btn navbar-left'. htmlspecialchars($params->get('moduleclass_sfx')) .'" data-toggle="modal" data-target="#modModal-'. $module->id .'">'. $module->title .' <span class="caret"></span></button>';
			}
    	}?>    
	
	<div class="modal fade" id="modModal-<?php echo $module->id;?>" tabindex="-1" role="dialog" aria-labelledby="label<?php echo $module->id;?>" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="modal-title" id="label<?php echo $module->id;?>"><?php echo $module->title;?></h4>
	      </div>
	      <div class="modal-body">
	      	<?php echo $module->content; ?>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
	      </div>
	    </div>
	  </div>
	</div>        
	
    <?php endif;        
}

function modChrome_ModuleInModal($module, &$params, &$attribs){
	//	https://www.spiralscripts.co.uk/Joomla-Tips/modal-windows-in-joomla-3.html
	$name = "modModal-".$module->id;
	$html = '<a href="#'.$name.'" data-toggle="modal" class="btn">'.$module->title.'</a>';
	$params = array();
	$params['title']  = $module->title;
	$params['height'] = 400;
	$params['width']  = "100%";
	//$params['url']    = "http://the-url/";
	$body = $module->content;
	echo $html .= JHtml::_('bootstrap.renderModal', $name, $params, $body);
}


function modChrome_LogInModal($module, &$params, &$attribs){

	$user = JFactory::getUser();
	$name = "modModal-".$module->id;
	// switch en caso de ser miembro
	if ($user->guest) : $logBtn = '<button class="btn btn-primary navbar-btn'. htmlspecialchars($params->get('moduleclass_sfx')) .'" data-toggle="modal" data-target="#'. $name .'">'. $module->title .' <span class="caret"></span></button>';
	else : $logBtn = '<a class="btn btn-link navbar-btn navbar-left" href="'. JURI::base() .'index.php?option=com_users&task=user.logout&'. JSession::getFormToken() .'=1">Salir <small class="glyphicon glyphicon-off"></small></a>';
	endif;
	
	$html = $logBtn;
	$params = array();
	$params['title']  = $module->title;
	$params['height'] = 400;
	$params['width']  = "100%";
	$body = $module->content;		
	echo $html .= JHtml::_('bootstrap.renderModal', $name, $params, $body);
	
}


?>

