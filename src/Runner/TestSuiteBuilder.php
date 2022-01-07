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

use Fit\Framework\TestSuite;
use Fit\Runner\Filesystem\Pathspec;
use Fit\Runner\Filter\TestAttributeFilter;
use Generator;
use ReflectionClass;
use ReflectionMethod;

/**
 * @internal This class is not covered by the backward compatibility promise for Fit.
 */
class TestSuiteBuilder
{
	private FileReflector $fileReflector;

	/**
	 * @param FileReflector $fileReflector
	 */
	public function __construct(FileReflector $fileReflector, TestCaseBuilder $testCaseBuilder)
	{
		$this->fileReflector = $fileReflector;
	}

	/**
	 * Builds the TestSuite
	 *
	 * @param Pathspec $pathspec
	 * @return Generator
	 * @throws Filesystem\Exception\PathspecException
	 * @throws Exception\UnreadableFileException
	 */
	public function buildFromPathspec(Pathspec $pathspec): Generator
	{
		$files = $pathspec->getFiles();

		foreach ($files as $file) {
			$fileClasses = $this->fileReflector->load($file);
			$testClasses = new TestAttributeFilter($fileClasses);

			foreach ($testClasses as $testClass) {
				yield $this->buildFromClass($testClass);
			}
		}
	}

	/**
	 * Builds a TestSuite from the given ReflectionClass.
	 *
	 * @param ReflectionClass $reflectionClass The ReflectionClass to build a TestSuite from
	 * @return TestSuite The TestSuite built
	 */
	public function buildFromClass(ReflectionClass $reflectionClass): TestSuite
	{
		// Note to self: WE ONLY EVER WANT TO CONSTRUCT THE FIXTURE ONCE PER TEST SUITE, WHAT IS THE BEST PLACE FOR THIS?
		$fixture = $reflectionClass->newInstance();
		$classMethods = $reflectionClass->getMethods(ReflectionMethod::IS_PUBLIC);

		foreach ( $classMethods as $classMethod ) {
			
		}

		return new TestSuite($fixture, []);
	}
}