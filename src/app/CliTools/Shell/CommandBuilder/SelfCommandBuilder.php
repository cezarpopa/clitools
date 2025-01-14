<?php

namespace CliTools\Shell\CommandBuilder;

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

use Phar;

class SelfCommandBuilder extends CommandBuilder
{

    /**
     * Initalized command
     */
    protected function initialize()
    {
        parent::initialize();

        $arguments = $_SERVER['argv'];

        // Check if command is run inside PHAR
        if (Phar::running()) {
            // PHAR version
            $this->setCommand(array_shift($arguments));
        } elseif (!empty($_SERVER['_'])) {
            // Plain PHP version
            if ($_SERVER['argv'][0] !== $_SERVER['_']) {
                $this->setCommand($_SERVER['_']);
                $this->addArgument(reset($arguments));
            }
        }

        // Fallback
        if (!$this->getCommand()) {
            $this->setCommand('php');
            $this->addArgument($_SERVER['PHP_SELF']);
        }
    }
}
