<?php declare(strict_types=1);
/**
 * This file is part of Fit.
 *
 * (c) Marijn van Wezel <marijnvanwezel@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Fit\Runner;

use Fit\Framework\TestCase;
use Fit\Runner\Exception\AbstractMethodException;
use Fit\Runner\Exception\MethodNotPublicException;
use Generator;
use ReflectionMethod;

/**
 * @internal This class is not covered by the backward compatibility promise for Fit.
 */
class TestCaseBuilder
{
	/**
	 * Builds a set of TestCases from the given iterable of ReflectionMethods.
	 *
	 * @param iterable<ReflectionMethod> $methodIterator The iterator to build the TestCases from
	 * @param object $fixture The fixture of the TestCases
	 * @return Generator<TestCase>
	 *
	 * @throws AbstractMethodException
	 * @throws MethodNotPublicException
	 */
	public function buildFromReflectionMethodIterable(iterable $methodIterator, object $fixture): Generator
	{
		foreach ($methodIterator as $method) {
			yield $this->buildFromReflectionMethod($method, $fixture);
		}
	}

	/**
	 * Builds a TestCase from the given ReflectionMethod.
	 *
	 * @param ReflectionMethod $reflectionMethod The ReflectionMethod to build a TestCase from
	 * @param object $fixture The fixture of the TestCase
	 * @return TestCase
	 *
	 * @throws MethodNotPublicException When the given method is not public
	 * @throws AbstractMethodException When the given method is abstract
	 */
	public function buildFromReflectionMethod(ReflectionMethod $reflectionMethod, object $fixture): TestCase
	{
		$className = $reflectionMethod->getDeclaringClass()->getName();
		$methodName = $reflectionMethod->getName();

		if (!$reflectionMethod->isPublic()) {
			throw new MethodNotPublicException('The test-method "' . $className . '::' . $methodName .
				'" cannot not be executed because it is not public.');
		}

		if ($reflectionMethod->isAbstract()) {
			throw new AbstractMethodException('The test-method "' . $className . '::' . $methodName .
				'" cannot be executed because it is abstract.');
		}

		return new TestCase($methodName, $reflectionMethod->getClosure($fixture));
	}
}