<?php
/**
 * @package     Joomla.Platform
 * @subpackage  Document
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('JPATH_PLATFORM') or die;

/**
 * JDocument head renderer
 *
 * @since  11.1
 */
class JDocumentRendererScripts extends JDocumentRenderer
{
	/**
	 * Renders the document head and returns the results as a string
	 *
	 * @param   string  $head     (unused)
	 * @param   array   $params   Associative array of values
	 * @param   string  $content  The script
	 *
	 * @return  string  The output of the script
	 *
	 * @since   11.1
	 *
	 * @note    Unused arguments are retained to preserve backward compatibility.
	 */
	public function render($scripts, $params = array(), $content = null)
	{
		return $this->fetchScripts($this->_doc);
	}

	/**
	 * Generates the head HTML and return the results as a string
	 *
	 * @param   JDocument  $document  The document for which the head will be created
	 *
	 * @return  string  The head hTML
	 *
	 * @since   11.1
	 */
	public function fetchScripts($document)
	{
	            
        // Get line endings
        $lnEnd = $document->_getLineEnd(); 	        
        $tab = $document->_getTab();
        $buffer = '';
        	    
        $defaultJsMimes = array('text/javascript', 'application/javascript', 'text/x-javascript', 'application/x-javascript');
        	            	    
        	    
        // Generate script file links
        foreach ($document->_scripts as $strSrc => $strAttr)
        {
            $buffer .= $tab . '<script src="' . $strSrc . '"';

            if (!is_null($strAttr['mime']) && (!$document->isHtml5() || !in_array($strAttr['mime'], $defaultJsMimes)))
            {
                $buffer .= ' type="' . $strAttr['mime'] . '"';
            }

            if ($strAttr['defer'])
            {
                $buffer .= ' defer';

                if (!$document->isHtml5())
                {
                    $buffer .= '="defer"';
                }
            }

            if ($strAttr['async'])
            {
                $buffer .= ' async';

                if (!$document->isHtml5())
                {
                    $buffer .= '="async"';
                }
            }

            $buffer .= '></script>' . $lnEnd;
        }

        // Generate scripts options
        $scriptOptions = $document->getScriptOptions();

        if (!empty($scriptOptions))
        {
            $buffer .= $tab . '<script type="text/javascript">' . $lnEnd;

            // This is for full XHTML support.
            if ($document->_mime != 'text/html')
            {
                $buffer .= $tab . $tab . '//<![CDATA[' . $lnEnd;
            }

            $pretyPrint  = (JDEBUG && defined('JSON_PRETTY_PRINT') ? JSON_PRETTY_PRINT : false);
            $jsonOptions = json_encode($scriptOptions, $pretyPrint);
            $jsonOptions = $jsonOptions ? $jsonOptions : '{}';

            // TODO: use .extend(Joomla.optionsStorage, options) when it will be safe
            $buffer .= $tab . 'var Joomla = Joomla || {};' . $lnEnd;
            $buffer .= $tab . 'Joomla.optionsStorage = ' . $jsonOptions . ';' . $lnEnd;

            // See above note
            if ($document->_mime != 'text/html')
            {
                $buffer .= $tab . $tab . '//]]>' . $lnEnd;
            }

            $buffer .= $tab . '</script>' . $lnEnd;
        }

        // Generate script declarations
        foreach ($document->_script as $type => $content)
        {
            $buffer .= $tab . '<script';

            if (!is_null($type) && (!$document->isHtml5() || !in_array($type, $defaultJsMimes)))
            {
                $buffer .= ' type="' . $type . '"';
            }

            $buffer .= '>' . $lnEnd;

            // This is for full XHTML support.
            if ($document->_mime != 'text/html')
            {
                $buffer .= $tab . $tab . '//<![CDATA[' . $lnEnd;
            }

            $buffer .= $content . $lnEnd;

            // See above note
            if ($document->_mime != 'text/html')
            {
                $buffer .= $tab . $tab . '//]]>' . $lnEnd;
            }

            $buffer .= $tab . '</script>' . $lnEnd;
        }

        // Generate script language declarations.
        if (count(JText::script()))
        {
            $buffer .= $tab . '<script';

            if (!$document->isHtml5())
            {
                $buffer .= ' type="text/javascript"';
            }

            $buffer .= '>' . $lnEnd;

            if ($document->_mime != 'text/html')
            {
                $buffer .= $tab . $tab . '//<![CDATA[' . $lnEnd;
            }

            $buffer .= $tab . $tab . '(function() {' . $lnEnd;
            $buffer .= $tab . $tab . $tab . 'Joomla.JText.load(' . json_encode(JText::script()) . ');' . $lnEnd;
            $buffer .= $tab . $tab . '})();' . $lnEnd;

            if ($document->_mime != 'text/html')
            {
                $buffer .= $tab . $tab . '//]]>' . $lnEnd;
            }

            $buffer .= $tab . '</script>' . $lnEnd;
        }

		return $buffer;
	}
}