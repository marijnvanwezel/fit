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

use Generator;

/**
 * This class runs the test cases and reports the results to a test listener.
 */
class TestRunner
{
	/**
	 * @var Generator<TestSuite> A generator of the test suites to run
	 */
	private readonly Generator $testSuites;

	/**
	 * Constructs a new TestRunner from the given TestSuite generator. We use a Generator for this for
	 * performance and UX reasons.
	 *
	 * In theory, a project can have millions of test suites, and we do not want to fill our memory with
	 * millions of TestSuite objects. Furthermore, building TestSuite objects is relatively slow, and we
	 * do not want to let the user wait for a (very) long time before actually running any tests.
	 *
	 * @param Generator<TestSuite> $testSuites A generator of the test suites to run
	 */
	public function __construct(Generator $testSuites)
	{
		$this->testSuites = $testSuites;
	}
}