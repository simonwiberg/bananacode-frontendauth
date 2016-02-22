<?php
/* 
 * Simon wiberg
 * simon@bananacode.com.br
 */

class Bananacode_Frontendauth_Block_Adminhtml_Configinfo extends Mage_Adminhtml_Block_Abstract implements Varien_Data_Form_Element_Renderer_Interface{
	
	protected $_template = '/bananacode/frontendauth/configinfo.phtml';
	
	public function render(Varien_Data_Form_Element_Abstract $element)
    {
        return $this->toHtml();
    }
	
}
