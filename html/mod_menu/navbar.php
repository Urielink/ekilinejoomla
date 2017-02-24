<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_menu
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$id = '';

if (($tagId = $params->get('tag_id', '')))
{
	$id = ' id="' . $tagId . '"';
}

// Personalización Bootstrap nav menu

// Necesitamos los parametros del template
	$app = JFactory::getApplication();
	$config = JFactory::getConfig();
	$templateparams= $app->getTemplate(true)->params;
	// para llamar al logotipo
	$logo = $templateparams->get('logo');
	//también necesitamos los parametros de posiciones para cargar modulos dentro del menu
	$doc      = JFactory::getDocument();
	$renderer = $doc->loadRenderer("modules");
	$raw      = array("style" => "none");

	/** Invocacion: echo $renderer->render("module-position", $raw, null); **/
	// 1) En caso de que escojas tener más de 2 menus, se añade una clase, basada en el id del item ($module->id)
	// 2) En caso de que querer que el menu se fije añande la clase : navbar-static-top, navbar-fixed-top o navbar-fixed-bottom en module > advanced : Menu Class Suffix
	// 3) El header, requiere una clase para centrar el contenido dentro del menu.

?>

<?php // NAVBAR default de bootstrap ?>

<div class="navbar navbar-default <?php echo $params->get('moduleclass_sfx').' '.'id'.$module->id; ?>">

	<div class="container<?php echo $params->get('header_class');?>">
		
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse<?php echo '.id'.$module->id;?>">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?php echo JURI::base( true );?>">
				<?php if ($logo != null ): echo '<img class="img-responsive" src="' . $logo . '" alt="'. htmlspecialchars($config->get( 'sitename' )) .'"/>'; else: echo htmlspecialchars($config->get( 'sitename' )); endif;?>              	
			</a>
		</div>
		
		<div id="nav-main" class="navbar-collapse <?php echo 'id'.$module->id;?> collapse">
            

<?php // Menu de joomla: The menu class is deprecated. Use nav instead. ?>		
<ul class="nav navbar-nav <?php echo $class_sfx; ?>"<?php echo $id; ?>>
<?php foreach ($list as $i => &$item)
{
	$class = 'item-' . $item->id;

	if ($item->id == $default_id)
	{
		$class .= ' default';
	}


	if (($item->id == $active_id) || ($item->type == 'alias' && $item->params->get('aliasoptions') == $active_id))
	{
		$class .= ' current';
	}

	if (in_array($item->id, $path))
	{
		$class .= ' active';
	}
	elseif ($item->type == 'alias')
	{
		$aliasToId = $item->params->get('aliasoptions');

		if (count($path) > 0 && $aliasToId == $path[count($path) - 1])
		{
			$class .= ' active';
		}
		elseif (in_array($aliasToId, $path))
		{
			$class .= ' alias-parent-active';
		}
	}

	if ($item->type == 'separator')
	{
		$class .= ' divider';
	}

	if ($item->deeper)
	{
		$class .= ' deeper';
	}

	if ($item->parent)
	{
		$class .= ' parent dropdown';
	}

	echo '<li class="' . $class . '">';

	switch ($item->type) :
		case 'separator':
		case 'component':
		case 'heading':
		case 'url':
			require JModuleHelper::getLayoutPath('mod_menu', 'navbar_' . $item->type);
			break;

		default:
			require JModuleHelper::getLayoutPath('mod_menu', 'navbar_url');
			break;
	endswitch;

	// The next item is deeper.
	if ($item->deeper)
	{
		echo '<ul class="dropdown-menu">';
	}
	// The next item is shallower.
	elseif ($item->shallower)
	{
		echo '</li>';
		echo str_repeat('</ul></li>', $item->level_diff);
	}
	// The next item is on the same level.
	else
	{
		echo '</li>';
	}
}
?></ul>

<?php // para añadir más modulos en navbar ?>
		<?php echo $renderer->render($module->title, $raw, null); ?>           
		</div><!--/.navbar-collapse -->            

	</div><!--/.container -->
	
</div><!--/.navbar-default -->

