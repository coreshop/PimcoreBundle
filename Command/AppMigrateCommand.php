<?php
/**
 * CoreShop.
 *
 * This source file is subject to the GNU General Public License version 3 (GPLv3)
 * For the full copyright and license information, please view the LICENSE.md and gpl-3.0.txt
 * files that are distributed with this source code.
 *
 * @copyright  Copyright (c) CoreShop GmbH (https://www.coreshop.org)
 * @license    https://www.coreshop.org/license     GPLv3 and CCL
 */

declare(strict_types=1);

namespace CoreShop\Bundle\PimcoreBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class AppMigrateCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->setName('coreshop:app:migrate')
            ->setDescription('Execute App migrations.')
            ->setHelp(
                <<<EOT
The <info>%command.name%</info> executes all CoreShop migrations.
EOT
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $application = $this->getApplication();
        $application->setCatchExceptions(false);

        $parameters = array_merge(
            ['command' => 'doctrine:migrations:migrate'],
            ['--prefix' => 'App\\Migrations'],
        );

        $this->getApplication()->setAutoExit(false);
        $exitCode = $this->getApplication()->run(new ArrayInput($parameters), $output);

        if (0 !== $exitCode) {
            $this->getApplication()->setAutoExit(true);

            $errorMessage = sprintf('The command terminated with an error code: %u.', $exitCode);
            $output->writeln("<error>$errorMessage</error>");

            throw new \Exception($errorMessage, $exitCode);
        }

        return 0;
    }
}
