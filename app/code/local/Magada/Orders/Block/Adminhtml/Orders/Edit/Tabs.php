<?php
class Magada_Orders_Block_Adminhtml_Orders_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
 
  public function __construct()
  {
      parent::__construct();
      $this->setId('form_tabs');
      $this->setDestElementId('edit_form'); // this should be same as the form id define above
      $this->setTitle(Mage::helper('orders')->__('Product Information'));
  }
 
  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('orders')->__('Upload CSV'),
          'title'     => Mage::helper('orders')->__('Upload CSV'),
          'content'   => $this->getLayout()->createBlock('orders/adminhtml_Orders_edit_tab_form')->toHtml(),
      ));
       $this->addTab('form_section1', array(
          'label'     => Mage::helper('orders')->__('Run CSV'),
          'title'     => Mage::helper('orders')->__('Run CSV'),
          'content'   => $this->getLayout()->createBlock('orders/adminhtml_Orders_edit_tab_upload')->toHtml(),
      ));
      
      
      return parent::_beforeToHtml();
  }
}