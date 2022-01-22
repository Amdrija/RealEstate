<?php

namespace Amdrija\RealEstate\Application\Exceptions;

use JetBrains\PhpStorm\Internal\LanguageLevelTypeAware;
use Throwable;

class ApplicationException extends \Exception
{
    public function __construct(string $message, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}