<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Bundle\DoctrineMigrationsBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Bundle\DoctrineBundle\Command\Proxy\DoctrineCommandHelper;
use Doctrine\DBAL\Migrations\Tools\Console\Command\MigrateCommand;

/**
 * Command for executing a migration to a specified version or the latest available version.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Jonathan H. Wage <jonwage@gmail.com>
 */
class MigrationsMigrateDoctrineCommand extends MigrateCommand
{
    protected function configure()
    {
        parent::configure();

        $this
            ->setName('doctrine:migrations:migrate')
            ->addOption('em', null, InputOption::VALUE_OPTIONAL, 'The entity manager to use for this command.')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        DoctrineCommandHelper::setApplicationEntityManager($this->getApplication(), $input->getOption('em'));

        $configuration = $this->getMigrationConfiguration($input, $output);
        DoctrineCommand::configureMigrations($this->getApplication()->getKernel()->getContainer(), $configuration, $input);

        parent::execute($input, $output);
    }
}
