<?php declare(strict_types=1);
/**
 * This file is part of Fit.
 *
 * (c) Marijn van Wezel <marijnvanwezel@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Fit\Runner\Filter;

use Fit\Attributes\Test;
use Iterator;

/**
 * Filter implementation that filters Reflection* classes based on whether they have
 * the Test attribute.
 *
 * @internal This class is not covered by the backward compatibility promise for Fit.
 */
class TestAttributeFilter extends AttributeFilter
{
	/**
	 * @inheritDoc
	 */
	public function __construct(array|Iterator $arrayOrIterator)
	{
		parent::__construct(Test::class, $arrayOrIterator);
	}
}