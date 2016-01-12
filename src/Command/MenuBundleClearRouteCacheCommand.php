<?php

namespace MenuBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MenuBundleClearRouteCacheCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('deadkashmenubundle:cache:clear');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $env = $input->getOption('env');
        $this->getContainer()->get('menubundle')->clearRouteCache($env);

        $output->writeln('Route cache for environment <info>'.$env.'</info> was cleared.');
    }

}