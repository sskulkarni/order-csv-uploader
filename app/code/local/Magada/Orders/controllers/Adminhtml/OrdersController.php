<?php

class Magada_Orders_Adminhtml_OrdersController extends Mage_Adminhtml_Controller_Action 
{
    
    public function indexAction() {

        $this->loadLayout();
        $this->renderLayout();
    }
    public function newAction(){  
        $path = Mage::getBaseDir('var') . DS . 'import' . DS . 'order' . DS;
        if (!file_exists($path) && !is_dir($path)) {
            mkdir($path,0777);
        } 
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('orders/adminhtml_orders_edit'))
                        ->_addLeft($this->getLayout()->createBlock('orders/adminhtml_orders_edit_tabs'));
        $this->renderLayout();
    }    
    public function saveAction(){
        
        if(isset($_FILES['fileinputname']['name']) and (file_exists($_FILES['fileinputname']['tmp_name']))) {
              try {
              if($_FILES['fileinputname']['type'] != 'text/csv')
                {
                    throw new Exception('CSV Format not Allowed, please save it in text/csv');
                }
                $uploader = new Varien_File_Uploader('fileinputname');
                $uploader->setAllowedExtensions(array('csv')); // or pdf or anything
                $uploader->setAllowRenameFiles(true);
                // setAllowRenameFiles(true) -> move your file in a folder the magento way
                // setAllowRenameFiles(true) -> move your file directly in the $path folder
                $uploader->setFilesDispersion(false);
               
                $path = Mage::getBaseDir('var') . DS . 'import' . DS . 'order' . DS;
                           
                $uploader->save($path, $_FILES['fileinputname']['name']);
             
                $data['fileinputname'] = $_FILES['fileinputname']['name'];
                Mage::getSingleton('adminhtml/session')->addSuccess('File has been Uploaded, Please Run Profile');
                $this->_redirect('*/*/new');
                }
                catch(Exception $e) {    
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/new');
              }
        }
        
    }
    public function saveAjaxAction()
    {
      if ($data = $this->getRequest()->getPost()) {
       try{
                $file = $data['csvfile'];
                $customers = $data['customers'];
                $path = Mage::getBaseDir().DS.'var'.DS.'import'.DS.'order'.DS.$file;
                $csv = new Varien_File_Csv();
                $csv->setDelimiter($data['delimeter']);
                $csv->setEnclosure($data['enclouser']);
                $csv->setLineLength(0);
                ini_set('auto_detect_line_endings', true);
                $data = $csv->getData($path);
                $full_array = array();
                $productSku = array();
                $Qtys = array();
                for ($i=0; $i < count($data) ; $i++) {
                    if($data[$i][1] == ""){
                        throw new Exception('Product SKU is not defined in csv');
                    }
                    if($data[$i][6] == ""){
                        throw new Exception('Product Quantity is not defined in csv');
                    }
                    $productSku[] = $data[$i][1];
                    $Qtys[] = $data[$i][6];
                    $sku_qty = array_combine($productSku, $Qtys);
                }

                $websites = Mage::app()->getWebsites();
                $website_id = $websites[1]->getId();
                $store_id =  $code = $websites[1]->getDefaultStore()->getId();

                $shippingMethod = 'flatrate_flatrate';
                $paymentMethod = 'checkmo';
                $quote = Mage::getModel('sales/quote')->setStoreId($store_id);
                $customer = Mage::getModel('customer/customer')
                                   ->setWebsiteId($website_id)
                                   ->loadByEmail($customers);  

                        $billing = $customer->getData()['default_billing'];
                        $shipping = $customer->getData()['default_shipping'];
                        $billing_address = Mage::getModel('customer/address')->load($billing)->getData();
                        $shipping_address = Mage::getModel('customer/address')->load($shipping)->getData();  
                        $quote->assignCustomer($customer);

                        foreach($sku_qty as $key => $value){
                              $productid = Mage::getModel('catalog/product')->getIdBySku($key);
                              $product = Mage::getModel('catalog/product');
                              $product ->load($productid);
                              $quote->addProduct($product,new Varien_Object(array('qty' => $value)));
                        }
                      
                     $billingAddress = $quote->getBillingAddress()->addData($billing_address);
                     $shippingAddress = $quote->getShippingAddress()->addData($shipping_address);
                     $shippingAddress->setCollectShippingRates(true)->collectShippingRates()
                                      ->setShippingMethod($shippingMethod)
                                      ->setPaymentMethod($paymentMethod);
                      $quote->getPayment()->importData(array('method' => $paymentMethod));
                      $quote->collectTotals()->save();
                      $service = Mage::getModel('sales/service_quote', $quote);
                      $service->submitAll();  
                      $order = $service->getOrder();
                      Mage::getSingleton('adminhtml/session')->addSuccess('Successfully Inserted Orders');  
                }
                catch(Exception $e)
                    {
                      Mage::log($e->getMessage());
                      Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                    }
            }
    }
    public function deleteAction(){

    $dir = Mage::getBaseDir('var') . DS . 'import' . DS . 'order' . DS;
      $files = array_diff( scandir($dir), array(".", "..") );
      foreach ($files as $f) {
        unlink($dir.$f);
      }
      Mage::getSingleton('adminhtml/session')->addSuccess('All file has been flushed');  
      
      $this->_redirect('orders/Adminhtml_orders/new');
    }
    
}
