<?php declare(strict_types=1);
/**
 * This file is part of Fit.
 *
 * (c) Marijn van Wezel <marijnvanwezel@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Fit\Config\Source;

use Fit\Config\Exception\InvalidOptionException;
use InvalidArgumentException;
use Symfony\Component\Console\Input\InputInterface;

/**
 * Represents the configuration from command-line arguments.
 */
class CliConfigSource implements ConfigSource
{
	private const ARGUMENT = 0b0;
	private const OPTION = 0b1;

	private const VALUE_TYPE = [
		'pathspec' => self::ARGUMENT,
		'config' => self::OPTION
	];

	/**
	 * @var InputInterface The command-line arguments
	 */
	private readonly InputInterface $input;

	/**
	 * @param InputInterface $input The command-line arguments
	 */
	public function __construct(InputInterface $input)
	{
		$this->input = $input;
	}

	/**
	 * @inheritDoc
	 */
	public function get(string $name): mixed
	{
		if (!isset(self::VALUE_TYPE[$name])) {
			throw new InvalidOptionException('The configuration option "' . $name . '" does not exist.');
		}

		try {
			return self::VALUE_TYPE[$name] === self::ARGUMENT ?
				$this->input->getArgument($name) :
				$this->input->getOption($name);
		} catch (InvalidArgumentException $exception) {
			throw new InvalidOptionException('The configuration option "' . $name . '" does not exist.', 0, $exception);
		}
	}
}