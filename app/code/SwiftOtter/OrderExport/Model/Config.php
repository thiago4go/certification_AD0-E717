<?php

namespace SwiftOtter\OrderExport\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Tests\NamingConvention\true\string;

class Config
{
    /*
     * @const here is used to set the config PATH
     */
    const CONFIG_PATH_ENABLED = 'sales/order_export/enabled';

    /**
     * @var  ScopeConfigInterface
     */
    private ScopeConfigInterface $scopeConfig;
    public function __construct(
        ScopeConfigInterface $scopeConfig
    )
    {
        $this->scopeConfig = $scopeConfig;
    }
    public function isEnabled(string  $scopeType = ScopeInterface::SCOPE_STORE,
                              ?string $scopeCode = null): bool
    {
        return $this->scopeConfig->isSetFlag(self::CONFIG_PATH_ENABLED, $scopeType, $scopeCode );
    }

}
