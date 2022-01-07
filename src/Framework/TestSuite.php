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

/**
 * This class represents a set of test cases that share the same fixture.
 */
class TestSuite
{
	/**
	 * @var TestCase[] The test cases in this suite
	 */
	private readonly array $testCases;

	/**
	 * @param TestCase[] $testCases The test cases in this suite
	 */
	public function __construct(array $testCases)
	{
		$this->testCases = $testCases;
	}
}