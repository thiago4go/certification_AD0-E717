<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Nikkei\Boleto\Block\Form;

/**
 * Block for Cash On Delivery payment method form
 */
class Boleto extends \Magento\OfflinePayments\Block\Form\AbstractInstruction
{
    /**
     * Cash on delivery template
     *
     * @var string
     */
    protected $_template = 'Nikkei_Boleto::form/boleto.phtml';
}
