<?php

namespace CliTools\Console\Command\Docker;

/*
 * CliTools Command
 * Copyright (C) 2016 WebDevOps.io
 * Copyright (C) 2015 Markus Blaschke <markus@familie-blaschke.net>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

use CliTools\Console\Filter\AnyParameterFilterInterface;
use CliTools\Shell\CommandBuilder\RemoteCommandBuilder;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ExecCommand extends AbstractCommand implements AnyParameterFilterInterface
{

    protected static $defaultName = 'docker:exec';
    /**
     * Configure command
     */
    protected function configure()
    {
        $this
             ->setDescription('Run defined command in docker container');
    }

    /**
     * Execute command
     *
     * @param  InputInterface  $input  Input instance
     * @param  OutputInterface $output Output instance
     *
     * @return int|null|void
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $paramList = $this->getFullParameterList();
        $container = $this->getApplication()
                          ->getConfigValue('docker', 'container');


        if (!empty($paramList)) {
            $firstParam = array_shift($paramList);

            $command = new RemoteCommandBuilder($firstParam, $paramList);

            $ret = $this->executeDockerExec($container, $command);
        } else {
            $output->writeln('<p-error>No command/parameter specified</p-error>');
            $ret = 1;
        }

        return $ret;
    }
}
