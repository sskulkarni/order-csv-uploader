<?php

class Magada_Orders_Helper_Data extends Mage_Core_Helper_Abstract
{
	/**
     * Check if current url is url for home page
     *
     * @return true
     */
    public function getIsHomePage()
    {
    	return Mage::getUrl('') == Mage::getUrl('*/*/*', array('_current'=>true, '_use_rewrite'=>true));
    }
}