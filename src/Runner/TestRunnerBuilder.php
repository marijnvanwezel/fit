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

use Fit\Config\Config;
use Fit\Framework\TestRunner;
use Fit\Runner\Exception\MissingPathspecException;
use Fit\Runner\Filesystem\Pathspec;

/**
 * This class is responsible for building a TestRunner instance.
 *
 * @internal This class is not covered by the backward compatibility promise for Fit.
 */
class TestRunnerBuilder
{
	/**
	 * Build and return the test runner.
	 *
	 * @param Config $config The configuration to build a TestRunner from
	 * @return TestRunner
	 *
	 * @throws Exception\UnreadableFileException
	 * @throws Filesystem\Exception\PathspecException
	 * @throws MissingPathspecException
	 */
	public function buildFromConfig(Config $config): TestRunner
	{
		if ($config->getPathspec() === null) {
			throw new MissingPathspecException("Missing pathspec.");
		}

		$pathspec = new Pathspec($config->getPathspec(), $config->getExtension());
		$testSuiteBuilder = new TestSuiteBuilder(new FileReflector());
		$testSuites = $testSuiteBuilder->buildFromPathspec($pathspec);

		foreach ($testSuites as $testSuite) {

		}

		return new TestRunner($testSuites);
	}
}