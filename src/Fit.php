<?php declare(strict_types=1);
/**
 * This file is part of Fit.
 *
 * (c) Marijn van Wezel <marijnvanwezel@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Fit;

class Fit
{
	private const NAME = 'Fit';
	private const VERSION = '0.0.1';

	/**
	 * Returns the name of the application.
	 *
	 * @return string
	 */
	public static function getName(): string
	{
		return self::NAME;
	}

	/**
	 * Returns the version of the application.
	 *
	 * @return string
	 */
	public static function getVersion(): string
	{
		return self::VERSION;
	}
}