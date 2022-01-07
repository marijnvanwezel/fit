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

use Fit\Runner\Exception\UnreadableFileException;
use ReflectionClass;
use ReflectionException;
use ReflectionFile\ReflectionFile;
use SplFileInfo;

/**
 * @internal This class is not covered by the backward compatibility promise for Fit.
 */
class FileReflector
{
	/**
	 * This function retrieves all testsuite classes in the given file. A file is a testsuite
	 * class if it is marked with the TestSuite annotation.
	 *
	 * @param SplFileInfo $file The file for which to get the TestSuite classes.
	 * @return ReflectionClass[] The TestSuite classes contained in the given file.
	 *
	 * @throws UnreadableFileException When the file cannot be read.
	 */
	public function load(SplFileInfo $file): array
	{
		try {
			$reflectionFile = new ReflectionFile($file);
		} catch (ReflectionException $exception) {
			throw new UnreadableFileException('The source file "' . $file->getPathname() .
				'" does not exist or could not be read.', 0, $exception);
		}

		try {
			return $reflectionFile->getClasses();
		} catch (ReflectionException $exception) {
			throw new UnreadableFileException('The source file "' . $reflectionFile->getPathName() .
				'" could not tested since it is not loaded. Have you set up an appropriate autoloader?', 0, $exception);
		}
	}
}