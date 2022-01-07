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

use Exception;
use Fit\Fit;
use Fit\UI\Application;
use Fit\UI\Console\Command\TestCommand;
use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Console\Command\HelpCommand;
use Symfony\Component\Console\Command\ListCommand;

/**
 * The main entry-point for the console application.
 */
final class ConsoleApplication extends BaseApplication implements Application
{
	public function __construct()
	{
		parent::__construct(Fit::getName(), Fit::getVersion());
	}

	/**
	 * @inheritDoc
	 * @throws Exception When running fails. Bypass this when {@link setCatchExceptions()}.
	 */
    public static function main(): int
    {
        return (new ConsoleApplication())->run();
    }

	/**
	 * @inheritDoc
	 */
	protected function getDefaultCommands(): array
	{
		return [new TestCommand(), new HelpCommand(), new ListCommand()];
	}
}