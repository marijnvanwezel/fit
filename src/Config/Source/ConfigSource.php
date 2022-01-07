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

interface ConfigSource
{
	/**
	 * Gets the specified configuration option.
	 *
	 * @param string $name The option to retrieve
	 * @return mixed The value of the configuration option
	 *
	 * @throws InvalidOptionException When the option does not exist
	 */
	public function get(string $name): mixed;
}