<?php declare(strict_types=1);
/**
 * This file is part of Fit.
 *
 * (c) Marijn van Wezel <marijnvanwezel@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Fit\Framework;

use Closure;

/**
 * This class represents a single test to be executed.
 */
class TestCase
{
	/**
	 * @var string The name of the test case
	 */
	private readonly string $name;

	/**
	 * @var Closure The test case to run
	 */
	private readonly Closure $testCase;

	/**
	 * @param string $name The name of the test case
	 * @param Closure $testCase The test case to run
	 */
	public function __construct(string $name, Closure $testCase)
	{
		$this->name = $name;
		$this->testCase = $testCase;
	}
}