<?php

namespace SwiftOtter\OrderExport\Action\OrderDataCollector;

use Magento\Sales\Api\Data\OrderInterface;
use SwiftOtter\OrderExport\Api\OrderDataCollectorInterface;
use SwiftOtter\OrderExport\Model\HeaderData;

class ExportHeaderData implements OrderDataCollectorInterface
{
    public function collect(OrderInterface $order, HeaderData $headerData): array
    {
        $shipDate = $headerData->getShipDate();
        return [
            'merchant_notes' => $headerData->getMerchantNotes(),
            'shipping' => [
                'ship_on' => ($shipDate !== null) ? $shipDate->format('d/m/Y') :  '',
            ],
        ];
    }
}
