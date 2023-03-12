<?php
declare(strict_types=1);
namespace SwiftOtter\OrderExport\Action;


use Magento\Framework\Exception\LocalizedException;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Store\Model\ScopeInterface;
use SwiftOtter\OrderExport\Model\Config;
use SwiftOtter\OrderExport\Model\HeaderData;

class ExportOrder
{
    /**
     * @var OrderRepositoryInterface
     */
    private $orderRepository;
    /**
     * @var Config
     */
    private $config;
    /**
     * @var CollectOrderData
     */
    private CollectOrderData $collectOrderData;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        Config $config,
        CollectOrderData $collectOrderData
    ){
        $this->orderRepository = $orderRepository;
        $this->config = $config;
        $this->collectOrderData = $collectOrderData;
    }
    public function execute(int $orderId, HeaderData $headerData): array
    {
        $order = $this->orderRepository->get($orderId);
        if (!$this->config->isEnabled(ScopeInterface::SCOPE_STORE,$order->getStoreId())) {
            throw new LocalizedException(__('Order Export is not enabled for this store'));
        }

        $results = ['success' => false, 'error' => null];

        $exportData = $this->collectOrderData->execute($order, $headerData);
        //TODO Export data to web service, save export details

        return $results;
    }
}
