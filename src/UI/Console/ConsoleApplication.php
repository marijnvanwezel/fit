<?php declare(strict_types=1);
/**
 * This file is part of Fit.
 *
 * (c) Marijn van Wezel <marijnvanwezel@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Fit\UI\Console;

use Fit\UI\Application;

/**
 * The main entry-point for the console application.
 */
final class ConsoleApplication implements Application
{
    /**
     * @inheritDoc
     */
    public static function main(): void
    {
        $application = new ConsoleApplication();

        $application->run($_SERVER['argv']);
    }

    /**
     * Runs the console application with the given arguments.
     *
     * @param array $arguments The arguments passed to the console application
     * @return void
     */
    private function run(array $arguments): void
    {

    }
}