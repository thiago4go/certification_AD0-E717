<?php

namespace SwiftOtter\OrderExport\Action;

use Magento\Sales\Api\Data\OrderInterface;
use Magento\Store\Model\ScopeInterface;
use SwiftOtter\OrderExport\Model\Config;

class PushDetailsToWebService
{
    private Config $config;

    public function __construct(
        Config $config
    )
    {
        $this->config = $config;
    }
    public function execute(array $orderDetails, OrderInterface $order) : bool
    {
        $apiUrl = $this->config->getApiUrl(ScopeInterface::SCOPE_STORE, $order->getStoreId());
        $apiToken = $this->config->getApiToken(ScopeInterface::SCOPE_STORE, $order->getStoreId());

        // TODO Make a http request to the API
                return true;
    }
}
