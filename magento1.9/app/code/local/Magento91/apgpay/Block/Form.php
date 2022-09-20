<?php
/**
 * E: test@test.com
 * W:www.magento.con
 */
class Magento91_apgpay_Block_Form extends Mage_Payment_Block_Form
{
    protected function _construct()
    {
        $this->setTemplate('apgpay/form.phtml');
        parent::_construct();
    }

}