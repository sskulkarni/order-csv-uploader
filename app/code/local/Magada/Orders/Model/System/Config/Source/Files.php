<?php

class Magada_Orders_Model_System_Config_Source_Files
{
   public function toOptionArray()
   {	
		$dir = Mage::getBaseDir('var') . DS . 'import' . DS . 'order' . DS;
   		$files = array_diff( scandir($dir), array(".", "..") );
		return array_combine($files, $files);
	}
}