<?php

namespace CliTools\Console\Command\Mysql;

/**
 * CliTools Command
 * Copyright (C) 2014 Markus Blaschke <markus@familie-blaschke.net>
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

use CliTools\Database\DatabaseConnection;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ConnectionsCommand extends \CliTools\Console\Command\AbstractCommand {

    /**
     * Configure command
     */
    protected function configure() {
        $this
            ->setName('mysql:connections')
            ->setDescription('List current connections');
    }

    /**
     * Execute command
     *
     * @param  InputInterface  $input  Input instance
     * @param  OutputInterface $output Output instance
     * @return int|null|void
     */
    public function execute(InputInterface $input, OutputInterface $output) {
        // Get current connection id
        $query = 'SELECT CONNECTION_ID()';
        $conId = DatabaseConnection::getOne($query);

        $query = 'SHOW PROCESSLIST';
        $processList = DatabaseConnection::getAll($query);

        // ########################
        // Output
        // ########################

        /** @var \Symfony\Component\Console\Helper\Table $table */
        $table = new Table($output);
        $table->setHeaders(array_keys(reset($processList)));

        foreach ($processList as $row) {
            // Exclude current connection id
            if ($row['Id'] === $conId) {
                continue;
            }

            $table->addRow(array_values($row));
        }

        $table->render();

        return 0;
    }

}