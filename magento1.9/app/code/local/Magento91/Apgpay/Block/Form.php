<?php
/**
 * E: sales@gloprocessor.com
 * W:www.magento.con
 */
class Magento91_Apgpay_Block_Form extends Mage_Payment_Block_Form
{
    protected function _construct()
    {
        $this->setTemplate('apgpay/form.phtml');
        parent::_construct();
    }

}