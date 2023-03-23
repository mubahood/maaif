<?php

/**
 * This file is part of the ramsey/collection library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Copyright (c) Ben Ramsey <ben@benramsey.com>
 * @license http://opensource.org/licenses/MIT MIT
 */

declare(strict_types=1);

namespace Ramsey\Collection\Exception;

use Throwable;

<<<<<<<< HEAD:admin/vendor/ramsey/collection/src/Exception/CollectionException.php
interface CollectionException extends Throwable
========
/**
 * Thrown when attempting to access an element that does not exist.
 */
class NoSuchElementException extends RuntimeException implements CollectionException
>>>>>>>> 97bc56319b7868edf4697b12621d4f8738eac0a6:vendor/ramsey/collection/src/Exception/NoSuchElementException.php
{
}
