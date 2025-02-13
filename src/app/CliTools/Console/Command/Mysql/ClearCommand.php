<?php

namespace CliTools\Console\Command\Mysql;

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

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ClearCommand extends AbstractCommand
{

    protected static $defaultName = 'mysql:clear';
    /**
     * Configure command
     */
    protected function configure()
    {
        parent::configure();

        $this
             ->setAliases(['mysql:create'])
             ->setDescription(
                 'Clear (recreate) database'
             )
             ->addArgument(
                 'db',
                 InputArgument::REQUIRED,
                 'Database name'
             );
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
        $database = $input->getArgument('db');

        $output->writeln('<h2>Clearing database "' . $database . '"</h2>');

        $output->writeln('<p>Creating database</p>');
        $this->execSqlCommand('DROP DATABASE IF EXISTS ' . addslashes((string) $database));
        $this->execSqlCommand('CREATE DATABASE ' . addslashes((string) $database));

        $output->writeln('<h2>Database "' . $database . '" recreated</h2>');

        return 0;
    }
}
