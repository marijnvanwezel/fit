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

use Iterator;
use ReflectionClass;
use ReflectionFunction;
use ReflectionMethod;

/**
 * Filter implementation that filters Reflection* classes based on whether they have
 * a specified attribute.
 *
 * @internal This class is not covered by the backward compatibility promise for Fit.
 */
class AttributeFilter extends Filter
{
	private string $attributeName;

	/**
	 * @inheritDoc
	 */
	public function __construct(string $attributeName, array|Iterator $arrayOrIterator)
	{
		$this->attributeName = $attributeName;

		parent::__construct($arrayOrIterator);
	}

	/**
	 * @inheritDoc
	 */
	public function accept(): bool
	{
		/** @var ReflectionClass|ReflectionMethod|ReflectionFunction $current */
		$current = parent::current();
		$annotations = $current->getAttributes($this->attributeName);

		return count($annotations) > 0;
	}
}