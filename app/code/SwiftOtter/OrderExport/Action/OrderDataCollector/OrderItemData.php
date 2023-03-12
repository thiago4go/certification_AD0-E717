<?php

namespace SwiftOtter\OrderExport\Action\OrderDataCollector;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
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
    private $productRepository;
    private $searchCriteriaBuilder;

    public function __construct(
        GetOrderExportItems $getOrderExportItems,
        ProductRepositoryInterface $productRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->getOrderExportItems = $getOrderExportItems;
        $this->productRepository = $productRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    public function collect(OrderInterface $order, HeaderData $headerData): array
    {
        $orderItems = $this->getOrderExportItems->execute($order);
        $skus = [];
        foreach ($orderItems as $orderItem) {
            $skus[] = $orderItem->getSku();
        }
        $productsBySku = $this->loadProducts($skus);

        $items = [];
        foreach ($orderItems as $orderItem) {
            $product = $productsBySku[$orderItem->getSku()] ?? null;
            $items[] = $this->transform($orderItem, $product);
        }

        return [
            'Items' => $items,
        ];
    }

    private function transform(OrderItemInterface $orderItem, ?ProductInterface $product): array
    {
        return  [
            'sku' => $orderItem->getSku(),
            'qty' => $orderItem->getQtyOrdered(),
            'item_price' => $orderItem->getBasePrice(),
            'item_cost' => $orderItem->getBaseCost(),
            'total' => $orderItem->getBaseRowTotal(),
        ];
    }

    /* a private method that load products returning an array of springs from ProductInterface by sku */
    /**
     * @param string[] $skus
     * @return ProductInterface[]
     */
    private function loadProducts(array $skus): array
    {
        $this->searchCriteriaBuilder->addFilter('sku', $skus, 'in');
        $searchCriteria = $this->searchCriteriaBuilder->create();
        /** @var ProductInterface[] $products */
        $products = $this->productRepository->getList($searchCriteria)->getItems();

        $productBySku = [];
        foreach ($products as $product) {
            $productBySku[$product->getSku()] = $product;
        }
        return $productBySku;
    }
    /* end of private method */
    /* a private method that get sku if that custom Attribute was overrode
    from the product and is part of order */
    private function getSku(OrderItemInterface $orderItem, ?ProductInterface $product): string
    {
        $sku = $orderItem->getSku();
        if ($product === null) {
            return $sku;
        }
        $skuOverride = $product->getCustomAttribute('sku_override');
        $skuOverrideValue = ($skuOverride !== null) ? $skuOverride->getValue(): null;
        if (!empty($skuOverrideValue)) {
            $sku = $skuOverrideValue;
        }
        }
}
