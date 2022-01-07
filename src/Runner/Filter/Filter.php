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

use ArrayIterator;
use FilterIterator;
use Iterator;

/**
 * FilterIterator implementation that takes an Iterator or an array.
 *
 * @internal This class is not covered by the backward compatibility promise for Fit.
 */
abstract class Filter extends FilterIterator
{
	/**
	 * @param array|Iterator $iteratorOrArray An Iterator or an array
	 */
	public function __construct(array|Iterator $iteratorOrArray)
	{
		$iterator = is_array($iteratorOrArray) ?
			new ArrayIterator($iteratorOrArray) : $iteratorOrArray;

		parent::__construct($iterator);
	}
}