<?php

class Magada_Orders_Model_System_Config_Source_Customers
{
   public function toOptionArray()
   {	
		$collection = Mage::getModel('customer/customer')
        ->getCollection()
        ->addAttributeToSelect('*')
        ->addFieldToFilter('group_id', 4);

        $customer = array();
        foreach ($collection as $cust) {
        	$customer[] = $cust->getEmail();
        }
        return array_combine($customer, $customer);
        
	}	
}