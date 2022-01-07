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
	 * @var Closure The test case to run
	 */
	private Closure $testCase;

	/**
	 * @param Closure $testCase The test case to run
	 */
	public function __construct(Closure $testCase)
	{
		$this->testCase = $testCase;
	}
}