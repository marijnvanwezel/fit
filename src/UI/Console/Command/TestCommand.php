<?php declare(strict_types=1);
/**
 * This file is part of Fit.
 *
 * (c) Marijn van Wezel <marijnvanwezel@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Fit\UI\Console\Command;

use Error;
use Exception;
use Fit\Config\Config;
use Fit\Config\Exception\InvalidConfigException;
use Fit\Config\Exception\MissingConfigFileException;
use Fit\Config\Exception\UnreadableConfigFileException;
use Fit\Config\Source\CliConfigSource;
use Fit\Config\Source\IniConfigSource;
use Fit\Framework\TestRunner;
use Fit\Runner\Exception\MissingPathspecException;
use Fit\Runner\Exception\UnreadableFileException;
use Fit\Runner\Filesystem\Exception\PathspecException;
use Fit\Runner\TestRunnerBuilder;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * This class handles the "test" command.
 */
class TestCommand extends Command
{
	private const NAME = 'test';
	private const DESCRIPTION = 'Run the tests in a pathspec';
	private const HELP = 'This command runs the tests in the given pathspec.';

	/**
	 * @return void
	 */
	protected function configure()
	{
		$this->setName(self::NAME)
			->setDescription(self::DESCRIPTION)
			->setHelp(self::HELP)
			->addArgument('pathspec', InputArgument::OPTIONAL, 'Specifies of which files the tests should be run')
			->addOption('extension', 'e', InputOption::VALUE_REQUIRED, 'Only search for tests in files with an extension that matches the specified regular expression', 'php')
			->addOption('config', 'c', InputOption::VALUE_REQUIRED, 'The configuration file to use for the test run')
			->addUsage('src/')
			->addUsage('src/.*.php')
			->addUsage('src/ --extension="php|phpt"');
	}

	/**
	 * @inheritDoc
	 */
	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		try {
			$config = $this->getConfig($input);
		} catch (UnreadableConfigFileException|MissingConfigFileException|InvalidConfigException $exception) {
			$output->writeln("fatal: " . $exception->getMessage());
			return self::FAILURE;
		}

		$testRunner = $this->getTestRunner($config);

		// TODO

		return self::SUCCESS;
	}

	/**
	 * @param InputInterface $input
	 * @return Config
	 * @throws InvalidConfigException|MissingConfigFileException|UnreadableConfigFileException
	 */
	private function getConfig(InputInterface $input): Config
	{
		$config = new Config();
		$config->addSource(new CliConfigSource($input));

		if ($config->hasConfigFile()) {
			$config->addSource(IniConfigSource::fromFilePath($config->getConfig()));
		}

		return $config;
	}

	/**
	 * @param Config $config
	 * @return TestRunner
	 * @throws MissingPathspecException
	 * @throws UnreadableFileException
	 * @throws PathspecException
	 */
	private function getTestRunner(Config $config): TestRunner
	{
		return (new TestRunnerBuilder())->buildFromConfig($config);
	}
}
