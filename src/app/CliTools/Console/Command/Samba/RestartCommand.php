<?php

namespace CliTools\Console\Command\Samba;

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

use CliTools\Console\Command\AbstractCommand;
use CliTools\Shell\CommandBuilder\CommandBuilder;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RestartCommand extends AbstractCommand
{

    protected static $defaultName = 'samba:restart';
    /**
     * Configure command
     */
    protected function configure()
    {
        $this
             ->setDescription('Restart Samba SMB daemon');
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
        $this->elevateProcess($input, $output);

        $commandSmbd = new CommandBuilder('service', 'smbd restart');
        $commandSmbd->executeInteractive();

        $commandNmbd = new CommandBuilder('service', 'nmbd restart');
        $commandNmbd->executeInteractive();

        return 0;
    }
}
