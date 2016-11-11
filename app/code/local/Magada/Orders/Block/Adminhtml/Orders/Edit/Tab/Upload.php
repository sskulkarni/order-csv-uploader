<?php
class Magada_Orders_Block_Adminhtml_Orders_Edit_Tab_Upload extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
    	$form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('orders_orders',array('legend'=>Mage::helper('orders')->__('Item information')));
          
        $fieldset->addField('csvfile', 'select', array(
          'label'     => Mage::helper('orders')->__('Upload csv'),
          'required'  => false,
          'name'      => 'csvfile',
          'values'    => Mage::getModel('orders/system_config_source_files')->toOptionArray(),
        ));


        $fieldset->addField('customers', 'select', array(
          'label'     => Mage::helper('orders')->__('Select Customer'),
          'name'      => 'customers',
          'values'    => Mage::getModel('orders/system_config_source_customers')->toOptionArray(),
        ));

         $fieldset->addField('delimeter', 'select', array(
          'label'     => Mage::helper('orders')->__('Specify Delimeter'),
          'name'      => 'delimeter',
          'values'    => Mage::getModel('orders/system_config_source_delimeter')->toOptionArray(),
        ));

        $fieldset->addField('enclouser', 'select', array(
          'label'     => Mage::helper('orders')->__('Specify Enclouser'),
          'name'      => 'enclouser',
          'values'    => Mage::getModel('orders/system_config_source_enclouser')->toOptionArray(),
        ));




        $fieldset->addField('uploadbutton', 'button', array(
          'label'     => Mage::helper('orders')->__('Run Csv'),
          'name'      => 'runcsv',
          'value'     => 'Run Csv',
          'onclick'   => 'javascript:runProfile();'

          
        ));

        $fieldset->addField('deletebutton', 'button', array(
          'label'     => Mage::helper('orders')->__('Delete All Csv'),
          'name'      => 'deletebutton',
          'value'     => 'Flush It!',
          'onclick'   => 'javascript:deleteProfiles();',
          'after_element_html' => '<small>Please Note: It will delete all csv from drop down</small>',
          ));

          
        return parent::_prepareForm();

    }

}