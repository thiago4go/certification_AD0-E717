<?php

namespace Nikkei\Boleto\Block\Form;

/**
 * Block for Boleto payment method form
 */
class Boleto extends \Magento\OfflinePayments\Block\Form\AbstractInstruction
{
    /**
     * Boleto template for both frontend and adminhtml
     *
     * @var string
     */
    protected $_template = 'Nikkei_Boleto::form/boleto.phtml';

}
