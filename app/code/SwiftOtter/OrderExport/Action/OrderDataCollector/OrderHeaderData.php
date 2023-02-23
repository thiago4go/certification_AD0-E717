<?php

namespace SwiftOtter\OrderExport\Action\OrderDataCollector;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Sales\Api\Data\OrderAddressInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\OrderAddressRepositoryInterface;
use SwiftOtter\OrderExport\Api\OrderDataCollectorInterface;
use SwiftOtter\OrderExport\Model\HeaderData;

class OrderHeaderData implements OrderDataCollectorInterface
{
    private OrderAddressRepositoryInterface $orderAddressRepository;
    private SearchCriteriaBuilder $searchCriteriaBuilder;

    public function __construct(
        OrderAddressRepositoryInterface $orderAddressRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ){

        $this->orderAddressRepository = $orderAddressRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    public function collect(OrderInterface $order, HeaderData $headerData): array
    {
        // TODO: Implement collect() method.
        $output = [
            "id"=> $order->getIncrementId(),
            "currency"=> $order->getBaseCurrencyCode(),
            "discount"=> $order->getBaseDiscountAmount(),
            "total"=> $order->getBaseGrandTotal(),
        ];

        $shippingAddress = $this->getShippingAddress($order);
        if ($shippingAddress) {
            $output ['shipping']  = [
                'name' => $shippingAddress->getFirstname() . ' ' . $shippingAddress->getLastname(),
                'address' => $shippingAddress->getStreet() ? implode(', ', $shippingAddress->getStreet()) : '',
                'city' => $shippingAddress->getCity(),
                'state' => $shippingAddress->getRegionCode(),
                'postcode' => $shippingAddress->getPostcode(),
                'country' => $shippingAddress->getCountryId(),
                'amount' => $order->getShippingAmount(),
                'method' => $order->getShippingDescription() ,
            ];
        }
        return $output;
    }
    /*
     * This fetch the shipping address, the ? allow to return a null.
     */
    private function getShippingAddress(OrderInterface $order): ?OrderAddressInterface
    {
        $this->searchCriteriaBuilder->addFilter('parent_id', $order->getEntityId())
            ->addFilter('address_type', 'shipping');
        $addresses = $this->orderAddressRepository->getList($this->searchCriteriaBuilder->create());

        if (count($addresses->getItems()) === 0){
            return null;
        }
        $items = $addresses->getItems();
        return reset($items);
    }

}
