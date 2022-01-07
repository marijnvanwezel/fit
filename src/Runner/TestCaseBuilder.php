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
use ReflectionException;
use ReflectionMethod;

/**
 * @internal This class is not covered by the backward compatibility promise for Fit.
 */
class TestCaseBuilder
{
	/**
	 * Builds a TestCase from the given ReflectionMethod.
	 *
	 * @param ReflectionMethod $reflectionMethod The ReflectionMethod to build a TestCase from
	 * @return TestCase
	 * @throws ReflectionException When the method's declaring class cannot be instantiated
	 */
	public function buildFromMethod(ReflectionMethod $reflectionMethod): TestCase
	{
		$this->validOrThrow($reflectionMethod);

		$declaringClass = $reflectionMethod->getDeclaringClass();
		$classInstance = $declaringClass->newInstance();

		$closure = $reflectionMethod->getClosure($classInstance);
	}

	/**
	 * Determines whether the given ReflectionMethod can form a valid TestCase. Throws an exception if
	 * and only if this it not the case.
	 *
	 * @param ReflectionMethod $reflectionMethod
	 * @return void
	 */
	private function validOrThrow(ReflectionMethod $reflectionMethod): void
	{
		if (!$reflectionMethod->isPublic()) {

		}
	}
}