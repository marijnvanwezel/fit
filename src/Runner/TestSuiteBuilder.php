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
use Fit\Runner\Filter\TestCaseAttributeFilter;
use Fit\Runner\Filter\TestSuiteAttributeFilter;
use Generator;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

/**
 * @internal This class is not covered by the backward compatibility promise for Fit.
 */
class TestSuiteBuilder
{
	private FileReflector $fileReflector;
	private TestCaseBuilder $testCaseBuilder;

	/**
	 * @param FileReflector $fileReflector
	 * @param TestCaseBuilder $testCaseBuilder
	 */
	public function __construct(FileReflector $fileReflector, TestCaseBuilder $testCaseBuilder)
	{
		$this->fileReflector = $fileReflector;
		$this->testCaseBuilder = $testCaseBuilder;
	}

	/**
	 * Builds a set of TestSuites from the given Pathspec.
	 *
	 * @param Pathspec $pathspec
	 * @return Generator<TestSuite>
	 *
	 * @throws Filesystem\Exception\PathspecException
	 * @throws Exception\UnreadableFileException
	 */
	public function buildFromPathspec(Pathspec $pathspec): Generator
	{
		$files = $pathspec->getFiles();

		foreach ($files as $file) {
			$fileClasses = $this->fileReflector->load($file);
			$testClasses = new TestSuiteAttributeFilter($fileClasses);

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
		$classMethods = $reflectionClass->getMethods(ReflectionMethod::IS_PUBLIC);
		$methodIterator = new TestCaseAttributeFilter($classMethods);

		$testCases = $this->testCaseBuilder->buildFromReflectionMethodIterable(
			$methodIterator,
			$reflectionClass->newInstance()
		);

		$testSuite = new TestSuite($testCases);


	}
}