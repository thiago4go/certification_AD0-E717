<?php
namespace Nikkei\Boleto\Model;
use Magento\Quote\Api\Data\PaymentMethodExtensionInterface;
/**
 * Boleto payment method model
 *
 * @method \Magento\Quote\Api\Data\PaymentMethodExtensionInterface getExtensionAttributes()
 *
 * @api
 * @since 100.0.2
 */
class Boleto extends \Magento\Payment\Model\Method\AbstractMethod
{
    public const PAYMENT_METHOD_BOLETO_CODE = 'boleto';

    /**
     * Payment method code
     *
     * @var string
     */
    protected $_code = self::PAYMENT_METHOD_BOLETO_CODE;

    /**
     * Boleto payment block paths
     *
     * @var string
     */
    protected $_formBlockType = \Nikkei\Boleto\Block\Form\Boleto::class;

    /**
     * Availability option
     *
     * @var bool
     */
    protected $_isOffline = true;

    /**
     * Get instructions text from config
     *
     * @return string
     */
    public function getInstructions()
    {
        $instructions = $this->getConfigData('instructions');
        return $instructions !== null ? trim($instructions) : '';
    }
}
