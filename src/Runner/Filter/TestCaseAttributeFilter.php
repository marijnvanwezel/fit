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

use Fit\Attributes\TestCase as TestCaseAttribute;
use Iterator;

/**
 * Filter implementation that filters Reflection* classes based on whether they have
 * the TestCase attribute.
 *
 * @internal This class is not covered by the backward compatibility promise for Fit.
 */
class TestCaseAttributeFilter extends AttributeFilter
{
	/**
	 * @inheritDoc
	 */
	public function __construct(array|Iterator $arrayOrIterator)
	{
		parent::__construct(TestCaseAttribute::class, $arrayOrIterator);
	}
}