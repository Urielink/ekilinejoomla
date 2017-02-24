<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_config
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
<fieldset class="form-horizontal">
	<legend><?php echo JText::_('COM_CONFIG_METADATA_SETTINGS'); ?></legend>
	<?php
	foreach ($this->form->getFieldset('metadata') as $field):
	?>
		<div class="control-group form-group">
			<div class="col-sm-3 control-label"><?php echo $field->label; ?></div>
			<div class="col-sm-9 controls"><?php echo $field->input; ?></div>
		</div>
	<?php
	endforeach;
	?>
</fieldset>
