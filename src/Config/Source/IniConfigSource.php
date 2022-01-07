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

use Fit\Config\Exception\InvalidConfigException;
use Fit\Config\Exception\InvalidOptionException;
use Fit\Config\Exception\MissingConfigFileException;
use Fit\Config\Exception\UnreadableConfigFileException;

/**
 * Represents the configuration from a file.
 */
class IniConfigSource implements ConfigSource
{
	/**
	 * @var array The contents of the ini file parsed to an array
	 */
	private readonly array $iniArray;

	/**
	 * @param array $iniArray The contents of the ini file parsed to an array
	 */
	public function __construct(array $iniArray)
	{
		$this->iniArray = $iniArray;
	}

	/**
	 * @inheritDoc
	 */
	public function get(string $name): mixed
	{
		return $this->iniArray[$name] ??
			throw new InvalidOptionException('The configuration option "' . $name . '" does not exist.');
	}

	/**
	 * Creates a new IniConfigSource from the given file path.
	 *
	 * @param string $filePath The file path from which to create a new IniConfigSource
	 * @return IniConfigSource
	 *
	 * @throws InvalidConfigException When the given file path is not a valid INI file
	 * @throws MissingConfigFileException When the given file path does not exist
	 * @throws UnreadableConfigFileException When the given file path is not readable, or is not a file
	 */
	public static function fromFilePath(string $filePath): IniConfigSource
	{
		if (!file_exists($filePath)) {
			throw new MissingConfigFileException(
				'The configuration file "' . $filePath . '" does not exist.');
		}

		if (!is_readable($filePath) || is_dir($filePath)) {
			throw new UnreadableConfigFileException(
				'The configuration file "' . $filePath . '" is not readable.');
		}

		$iniArray = parse_ini_file($filePath, true);

		if ($iniArray === false) {
			throw new InvalidConfigException(
				'The configuration file "' . $filePath . '" could not be parsed.');
		}

		return new IniConfigSource($iniArray);
	}
}