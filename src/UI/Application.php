<?php declare(strict_types=1);
/**
 * This file is part of Fit.
 *
 * (c) Marijn van Wezel <marijnvanwezel@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Fit\UI;

/**
 * The main entry-point of the application.
 */
interface Application
{
    /**
     * The main entry-point of the application.
     *
     * @return int The exit code of the application.
     */
    public static function main(): int;
}