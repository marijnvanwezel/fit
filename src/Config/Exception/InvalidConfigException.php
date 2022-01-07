<?php declare(strict_types=1);
/**
 * This file is part of Fit.
 *
 * (c) Marijn van Wezel <marijnvanwezel@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Fit\Config\Exception;

use Exception;

/**
 * Thrown when the config file specified through the "config" option is invalid.
 */
class InvalidConfigException extends Exception
{
}