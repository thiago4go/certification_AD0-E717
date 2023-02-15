<?php

namespace Nikkei\Boleto\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Boleto extends Command
{
    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this->setName('boleto:faturar')
            ->setDescription('Gera fatura de pedido em boleto');
    }

    /**
     * @inheritdoc
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        echo "faturado";
        return 0;
    }
}
