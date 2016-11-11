<?php

class Magada_Orders_Model_System_Config_Source_Delimeter
{
   public function toOptionArray()
   {	
		$delimeter = array(';' =>  ';',',' =>  ',');
        return $delimeter;
        
	}	
}