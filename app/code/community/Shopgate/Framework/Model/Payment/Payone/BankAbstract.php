<?php
/**
 * Shopgate GmbH
 *
 * URHEBERRECHTSHINWEIS
 *
 * Dieses Plugin ist urheberrechtlich geschützt. Es darf ausschließlich von Kunden der Shopgate GmbH
 * zum Zwecke der eigenen Kommunikation zwischen dem IT-System des Kunden mit dem IT-System der
 * Shopgate GmbH über www.shopgate.com verwendet werden. Eine darüber hinausgehende Vervielfältigung, Verbreitung,
 * öffentliche Zugänglichmachung, Bearbeitung oder Weitergabe an Dritte ist nur mit unserer vorherigen
 * schriftlichen Zustimmung zulässig. Die Regelungen der §§ 69 d Abs. 2, 3 und 69 e UrhG bleiben hiervon unberührt.
 *
 * COPYRIGHT NOTICE
 *
 * This plugin is the subject of copyright protection. It is only for the use of Shopgate GmbH customers,
 * for the purpose of facilitating communication between the IT system of the customer and the IT system
 * of Shopgate GmbH via www.shopgate.com. Any reproduction, dissemination, public propagation, processing or
 * transfer to third parties is only permitted where we previously consented thereto in writing. The provisions
 * of paragraph 69 d, sub-paragraphs 2, 3 and paragraph 69, sub-paragraph e of the German Copyright Act shall remain unaffected.
 *
 * @author Shopgate GmbH <interfaces@shopgate.com>
 */


/**
 * Handler for all online bank transfer payment interfaces
 *
 * Note: any online bank transfer config needs to be enabled for
 * Giro, Ideal, SUE to work, they don't actually need to be selected.
 *
 * @package Class Shopgate_Framework_Model_Payment_Payone_BankAbstract
 * @author  Konstantin Kiritsenko <konstantin@kiritsenko.com>
 */
class Shopgate_Framework_Model_Payment_Payone_BankAbstract extends Shopgate_Framework_Model_Payment_Payone_Abstract
{
    const PAYONE_CORE_MODEL_CONFIG_IDENTIFIER = 'payone_online_bank_transfer';
    const PAYMENT_MODEL                       = 'payone_core/payment_method_onlineBankTransfer';

    /**
     * @param Mage_Sales_Model_Order $order
     * @return Mage_Sales_Model_Order
     * @throws Exception
     */
    public function manipulateOrderWithPaymentData($order)
    {
        $this->getOrder()->getPayment()->setPayoneOnlinebanktransferType($this->_getConfigCode());

        return parent::manipulateOrderWithPaymentData($order);
    }

}