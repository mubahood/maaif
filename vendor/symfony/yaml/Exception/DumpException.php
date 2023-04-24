<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

<<<<<<<< HEAD:admin/vendor/symfony/yaml/Exception/DumpException.php
namespace Symfony\Component\Yaml\Exception;

/**
 * Exception class thrown when an error occurs during dumping.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class DumpException extends RuntimeException
{
========
if (\PHP_VERSION_ID < 80000 && extension_loaded('tokenizer')) {
    class PhpToken extends Symfony\Polyfill\Php80\PhpToken
    {
    }
>>>>>>>> 97bc56319b7868edf4697b12621d4f8738eac0a6:vendor/symfony/polyfill-php80/Resources/stubs/PhpToken.php
}
