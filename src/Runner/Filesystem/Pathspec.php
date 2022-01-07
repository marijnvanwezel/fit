<?php declare(strict_types=1);
/**
 * This file is part of Fit.
 *
 * (c) Marijn van Wezel <marijnvanwezel@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Fit\Runner\Filesystem;

use Error;
use Exception;
use FilesystemIterator;
use Fit\Runner\Filesystem\Exception\PathspecException;
use Generator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

/**
 * This class contains helper functions for working with a pathspec.
 *
 * @internal This class is not covered by the backward compatibility promise for Fit
 */
class Pathspec
{
	/**
	 * @var string The pathspec
	 */
	private readonly string $pathspec;

	/**
	 * @var string|null Limits the files returned based their file extension (can be a regex)
	 */
	private readonly ?string $extension;

	/**
	 * @param string $pathspec The pathspec
	 * @param string|null $extension Limits the files returned based their file extension (can be a regex)
	 */
	public function __construct(string $pathspec, ?string $extension = null)
	{
		$this->pathspec = $pathspec;
		$this->extension = $extension;
	}

	/**
	 * Retrieve the files that match this pathspec.
	 *
	 * @return Generator<SplFileInfo> The files that match this pathspec, as a Generator
	 * @throws PathspecException When the resolution of the pathspec fails
	 */
	public function getFiles(): Generator
	{
		// Get the initial files and directories that match the pathspec
		$paths = glob($this->pathspec, GLOB_ERR);

		if ($paths === false) {
			throw new PathspecException(
				'Glob failed while resolving the pathspec "' . $this->pathspec . '".'
			);
		}

		foreach ($paths as $path) {
			if (is_dir($path)) {
				yield from $this->traverseDirectory($path);
			} else {
				$file = new SplFileInfo($path);

				if ($this->isValid($file)) {
					yield $file;
				}
			}
		}
	}

	/**
	 * Returns the pathspec as a string.
	 *
	 * @return string
	 */
	public function getPathspec(): string
	{
		return $this->pathspec;
	}

	/**
	 * Turns this object into a string.
	 *
	 * @return string
	 */
	public function __toString(): string
	{
		return $this->pathspec;
	}

	/**
	 * Recursively traverses the given path and returns an array with the paths of all files it contains.
	 *
	 * @param string $directoryPath The path to recursively traverse.
	 * @return Generator<SplFileInfo> A generator for the full paths of the files contained in the path.
	 * @throws PathspecException When the directory traversal fails.
	 */
	private function traverseDirectory(string $directoryPath): Generator
	{
		$directoryIterator = new RecursiveDirectoryIterator($directoryPath, FilesystemIterator::UNIX_PATHS);
		$fileIterator = new RecursiveIteratorIterator($directoryIterator);

		foreach ($fileIterator as $file) {
			if (!$file->isFile() || !$this->isValid($file)) {
				continue;
			}

			yield $file;
		}
	}

	/**
	 * This function determines whether the given file should be included in the list of paths
	 * to return. It does not check whether the path of the file conforms to the pathspec, but
	 * only does additional filtering (i.e. check whether the file extension is correct). It
	 * returns true if and only if the given file should be included.
	 *
	 * @param SplFileInfo $file
	 * @return bool
	 * @throws PathspecException
	 */
	private function isValid(SplFileInfo $file): bool
	{
		return $this->isExtensionValid($file);
	}

	/**
	 * Returns true if and only if the given file has an extension that matches the required
	 * file extension pattern.
	 *
	 * @param SplFileInfo $file
	 * @return bool
	 * @throws PathspecException
	 */
	private function isExtensionValid(SplFileInfo $file): bool
	{
		if (!isset($this->extension)) {
			return true;
		}

		$pattern = sprintf('/^%s$/', $this->extension);

		try {
			// We set a temporary error handler, so we can catch any errors thrown by preg_match and avoid an ugly
			// warning.
			set_error_handler(fn () => throw new Exception());

			$isValid = preg_match($pattern, $file->getExtension()) === 1;
		} catch (Exception $e) {
			// We do nothing here, since we will handle any errors emitted by preg_match later through
			// preg_last_error. We do this, because not all preg failures are reported by throwing an error.
		} finally {
			// Finally, we restore the previous error handler.
			restore_error_handler();
		}

		switch (preg_last_error()) {
			case PREG_NO_ERROR:
				return $isValid;
			case PREG_INTERNAL_ERROR:
				throw new PathspecException('The file extension pattern "' . $this->extension . '" is not valid.');
			default:
				throw new PathspecException('The evaluation of the file extension pattern "' . $this->extension . '" failed: ' . preg_last_error_msg() . '.');
		}
	}
}
