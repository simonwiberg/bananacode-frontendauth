<?php
/* 
 * Simon wiberg
 * simon@bananacode.com.br
 */

class Bananacode_Frontendauth_Model_Options_Hostvariable
{
	public function toOptionArray() {
        $returnArray[] = array('value'=>'0', 'label'=>Mage::helper('directory')->__('Mage::helper(\'core/http\')->getRemoteAddr()'));
        $returnArray[] = array('value'=>'1', 'label'=>Mage::helper('directory')->__('$_SERVER[\'HTTP_CLIENT_IP\']'));
        $returnArray[] = array('value'=>'3', 'label'=>Mage::helper('directory')->__('$_SERVER[\'HTTP_X_FORWARDED_FOR\']'));
		return $returnArray;
	}

}
	