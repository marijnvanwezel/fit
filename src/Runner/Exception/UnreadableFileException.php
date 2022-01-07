<?php declare(strict_types=1);
/**
 * This file is part of Fit.
 *
 * (c) Marijn van Wezel <marijnvanwezel@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Fit\Runner\Exception;

use Exception;

/**
 * This exception is thrown when the reading of a test file failed.
 */
class UnreadableFileException extends Exception
{
}