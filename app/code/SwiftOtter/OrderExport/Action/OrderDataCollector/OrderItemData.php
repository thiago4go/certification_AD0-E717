<?php

namespace SwiftOtter\OrderExport\Action\OrderDataCollector;

use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\Data\OrderItemInterface;
use SwiftOtter\OrderExport\Action\GetOrderExportItems;
use SwiftOtter\OrderExport\Api\OrderDataCollectorInterface;
use SwiftOtter\OrderExport\Model\HeaderData;

class OrderItemData implements OrderDataCollectorInterface
{
    /**
     * @var GetOrderExportItems
     */
    private $getOrderExportItems;
    public function __construct(
        GetOrderExportItems $getOrderExportItems
    ) {
        $this->getOrderExportItems = $getOrderExportItems;
    }

    public function collect(OrderInterface $order, HeaderData $headerData): array
    {
        $items = [];
        foreach ($this->getOrderExportItems->execute($order) as $orderItem) {
            $items[] = $this->transform($orderItem);
        }

        return [
            'Items' => $items,
        ];
    }

    private function transform(OrderItemInterface $orderItem): array
    {
        return  [
            'sku' => $orderItem->getSku(),
            'qty' => $orderItem->getQtyOrdered(),
            'item_price' => $orderItem->getBasePrice(),
            'item_cost' => $orderItem->getBaseCost(),
            'total' => $orderItem->getBaseRowTotal(),
        ];
    }

}
