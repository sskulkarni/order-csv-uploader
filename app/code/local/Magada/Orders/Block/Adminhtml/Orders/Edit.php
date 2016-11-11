<?php
class Magada_Orders_Block_Adminhtml_Orders_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                  
        $this->_objectId = 'id';
        $this->_blockGroup = 'orders';
        $this->_controller = 'adminhtml_orders';
         
        $this->_updateButton('save', 'label', Mage::helper('orders')->__('Save'));
        
         
       
    }
 
    public function getHeaderText()
    {
        return Mage::helper('orders')->__('Order Uploader');
    }
}
