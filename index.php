<?php 
/**
 * @package		Joomla.Site
 * @subpackage	Templates.bixniajfw
 * @copyright	Copyright (C) 2015 Urielink Pinlazk. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 **/

defined('_JEXEC') or die('Restricted access');

/* PERSONALIZACION */
include_once('templates/'.$this->template.'/includes/functions.php');
include_once('templates/'.$this->template.'/includes/setup.php');
include_once('templates/'.$this->template.'/includes/options.php');
?>
<!DOCTYPE html>
<html xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
<head>
<jdoc:include type="head" />
</head>
<body class="<?php echo $pageclass; ?>">
<?php echo $gtagmanage;?>
<?php 
/** 
 * Tipos de modulos:
 * https://docs.joomla.org/Jdoc_statements 
 * Determinar existencia de espacios:
 * https://docs.joomla.org/JDocumentHTML/countModules
 * http://forum.joomla.org/viewtopic.php?p=1872685
 */?>
 
<jdoc:include type="modules" name="top" style="none"/> 
	
<div class="<?php echo $fluidContainer;?>">

	<header>	
		<jdoc:include type="modules" name="header" style="none"/> 
	</header>	
	
	<?php if ($this->countModules('section-top')): ?>
		<section>
			<jdoc:include type="modules" name="section-top" style="none"/> 
		</section>
	<?php endif; ?>		
<?php // en caso de layout 1, 2 o 3 establece las medidas de todo?>		
	<?php echo $rowOpen;?>
		
	<section class="<?php echo $comWidth;?>" >
	
		<?php if ($this->countModules('content-top')): ?>
				<jdoc:include type="modules" name="content-top" style="none"/> 
		<?php endif; ?>
		
				<jdoc:include type="message" />

				<jdoc:include type="component" />
		
		<?php if ($this->countModules('content-bottom')): ?>
				<jdoc:include type="modules" name="content-bottom" style="none"/> 
		<?php endif; ?>				
		
	</section>
	
    <?php if ($this->countModules('aside-left') && $leftColumn != 0): ?>
        <aside class="<?php echo $leftWidth;?>" >
            <jdoc:include type="modules" name="aside-left" style="none"/> 
        </aside>    
    <?php endif; ?>     
	
	<?php if ($this->countModules('aside-right') && $rightColumn != 0): ?>
		<aside class="<?php echo $rightWidth;?>" >
			<jdoc:include type="modules" name="aside-right" style="none"/> 
		</aside>	
	<?php endif; ?>	
	
	<?php echo $rowClose;?>
<?php // fin en caso de layout 1-2-3 ?>		
	
	<?php if ($this->countModules('section-bottom')): ?>
		<section class="row">
			<jdoc:include type="modules" name="section-bottom" style="none"/> 
		</section>
	<?php endif; ?>		
		
</div>  
		
<footer>
    <div class="container">

<?php if ($this->countModules('footer')): ?>
	<div class="row">
		<jdoc:include type="modules" name="footer" style="none"/> 
	</div>	
<?php endif; ?>		

	<small>&copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars($config->get( 'sitename' )); ?><i class="nav-text pull-right"><?php echo JText::_('TPL_BIXNIAJFW_POWERED_BY');?> <a href="http://www.joomla.org/">Joomla!&#174;</a></i></small>
	
	</div>
</footer>	
	

<jdoc:include type="modules" name="bottom" style="none"/>
<jdoc:include type="modules" name="debug" style="none"/>

<?php echo $endScripts; ?>
</body>
</html>