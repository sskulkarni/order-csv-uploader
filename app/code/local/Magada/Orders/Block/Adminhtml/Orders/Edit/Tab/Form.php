<?php
class Magada_Orders_Block_Adminhtml_Orders_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('orders_orders',array('legend'=>Mage::helper('orders')->__('Item information')));
          
        $fieldset->addField('fileinputname', 'file', array(
          'label'     => Mage::helper('orders')->__('Upload csv'),
          'name'      => 'fileinputname',
          'after_element_html' => '<br/><small>Please Note: The SKU must be on 2nd position of every row and product quantity must be on 7th position</small><br/><br/><small>Csv must not any empty row</small>',
        ));
          
        return parent::_prepareForm();
    }
}
