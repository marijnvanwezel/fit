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
use Generator;

/**
 * This class represents a set of test cases that share the same fixture.
 */
class TestSuite
{
	/**
	 * @var Generator<TestCase> The test cases in this TestSuite
	 */
	private readonly Generator $testCases;

	/**
	 * @var Closure The setUp method to call before each test case
	 */
	private readonly Closure $setUp;

	/**
	 * @var Closure The tearDown method to call after each test case
	 */
	private readonly Closure $tearDown;

	/**
	 * @param Generator<TestCase> $testCases The test cases in this suite
	 */
	public function __construct(Generator $testCases)
	{
		$this->testCases = $testCases;
	}

	/**
	 * Set the setUp closure for this TestSuite.
	 *
	 * @note This function changes a readonly attribute and may only be called once.
	 *
	 * @param Closure $setUp The setUp method for this TestSuite
	 * @return void
	 */
	public function setSetUp(Closure $setUp): void
	{
		$this->setUp = $setUp;
	}

	/**
	 * Set the tearDown closure for this TestSuite.
	 *
	 * @note This function changes a readonly attribute and may only be called once.
	 *
	 * @param Closure $tearDown The tearDown method for this TestSuite
	 * @return void
	 */
	public function setTearDown(Closure $tearDown): void
	{
		$this->tearDown = $tearDown;
	}
}
