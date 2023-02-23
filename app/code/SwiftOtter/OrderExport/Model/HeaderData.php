<?php
/*
 * this is a way to encapsulate the input strings
 */
declare(strict_types=1);
namespace SwiftOtter\OrderExport\Model;
class HeaderData
{
    /** @var ?\DateTime */
    private $shipDate;

    /** @var string */
    private $merchantNotes;

    public function getShipDate(): ?\DateTime
    {
        return $this->shipDate;
    }
    public function setShipDate(?\DateTime $shipDate): HeaderData
    {
        $this->shipDate = $shipDate;
        return $this;
    }

    public function getMerchantNotes(): string
    {
        return (string) $this->merchantNotes;
    }

    public function setMerchantNotes(string $merchantNotes): HeaderData
    {
        $this->merchantNotes = $merchantNotes;
        return $this;
    }

}
