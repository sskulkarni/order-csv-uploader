<?php

class Magada_Orders_Model_System_Config_Source_Enclouser
{
   public function toOptionArray()
   {	
	   
       $enclouser = array('"' =>  '"',"'" =>  "'");
        return $enclouser;
        
	}	
}