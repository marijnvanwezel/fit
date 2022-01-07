<?php declare(strict_types=1);
/**
 * This file is part of Fit.
 *
 * (c) Marijn van Wezel <marijnvanwezel@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Fit\Config;

use Fit\Config\Exception\InvalidOptionException;
use Fit\Config\Source\ConfigSource;

/**
 * This file represents the current configuration of Fit.
 */
class Config
{
	/**
	 * @var ConfigSource[] The config sources to consult in order
	 */
	private array $sources = [];

	/**
	 * Adds a config source to consult.
	 *
	 * @param ConfigSource $source The source to add
	 * @param bool $append Whether to append it to the list of config sources (true), or to prepend it (false)
	 * @return void
	 */
	public function addSource(ConfigSource $source, bool $append = true): void
	{
		if ($append) {
			$this->sources[] = $source;
		} else {
			array_unshift($this->sources, $source);
		}
	}

	/**
	 * Gets the specified configuration option. Returns NULL if the requested option
	 * does not exist in any of the sources.
	 *
	 * @param string $name The option to retrieve
	 * @return mixed The value of the configuration option, or NULL if it does not exist
	 */
	public function get(string $name): mixed
	{
		foreach ($this->sources as $source) {
			try {
				return $source->get($name);
			} catch (InvalidOptionException $exception) {}
		}

		return null;
	}

	/**
	 * @return string|null
	 */
	public function getPathspec(): ?string
	{
		return $this->get('pathspec');
	}

	/**
	 * @return bool
	 */
	public function hasPathspec(): bool
	{
		return $this->getPathspec() !== null;
	}

	/**
	 * @return string|null
	 */
	public function getConfig(): ?string
	{
		return $this->get('config') ?? null;
	}

	/**
	 * @return bool
	 */
	public function hasConfigFile(): bool
	{
		return $this->getConfig() !== null;
	}

	/**
	 * @return string|null
	 */
	public function getExtension(): ?string
	{
		return $this->get('extension') ?? null;
	}

	/**
	 * @return bool
	 */
	public function hasExtension(): bool
	{
		return $this->getExtension() !== null;
	}
}