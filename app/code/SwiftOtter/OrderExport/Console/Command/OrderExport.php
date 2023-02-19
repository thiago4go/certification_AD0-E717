<?php

namespace SwiftOtter\OrderExport\Console\Command;


use SwiftOtter\OrderExport\Action\CollectOrderData;
use SwiftOtter\OrderExport\Model\HeaderData;
use SwiftOtter\OrderExport\Model\HeaderDataFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class OrderExport extends Command
{
    const ARG_NAME_ORDER_ID = 'order-id';
    const OPT_NAME_SHIP_DATE = 'ship-date';
    const OPT_NAME_MERCHANT_NOTES = 'notes';
    private $headerDataFactory;
    private CollectOrderData $collectOrderData;

    public function __construct(
        HeaderDataFactory $headerDataFactory,
        CollectOrderData $collectOrderData,
        string $name = null)
    {
        parent::__construct($name);
        $this->headerDataFactory = $headerDataFactory;
        $this->collectOrderData = $collectOrderData;
    }

    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this->setName('order-export:run')
            ->setDescription('Export orders to ERP')
            ->addArgument(
                self::ARG_NAME_ORDER_ID,
                InputArgument::REQUIRED,
                'Order ID'
            )
            ->addOption(
                self::OPT_NAME_SHIP_DATE,
                'd',
                InputOption::VALUE_OPTIONAL,
                'Shipping date in format YYYY-MM-DD'
            )
            ->addOption(
                self::OPT_NAME_MERCHANT_NOTES,
                null,
                InputOption::VALUE_OPTIONAL,
                'Merchant notes'
            );
    }

    /**
     * @inheritdoc
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $orderID = (int) $input->getArgument(self::ARG_NAME_ORDER_ID);
        $notes = $input->getOption(self::OPT_NAME_MERCHANT_NOTES);
        $shipDate = $input->getOption(self::OPT_NAME_SHIP_DATE);

        /** @var HeaderData $headerData */
        $headerData =$this->headerDataFactory->create();
        if ($shipDate){
            $headerData->setShipDate(new \DateTime($shipDate));
        }
        if ($notes) {
            $headerData->setMerchantNotes($notes);
        }

        $orderData = $this->collectOrderData->execute($orderID, $headerData);

        $output->writeln(print_r($orderData, true));
//        $output->writeln(__('Order ID is %1', $orderID));
//        $output->writeln(__('Notes is "%1"', $notes));
//        $output->writeln(__('Ship date is %1', $shipDate));

        return 0;
    }
}
