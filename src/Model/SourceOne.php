<?php
declare(strict_types=1);

namespace App\Model;

class SourceOne
{
    public ?string $foo;
    public string $bar;
    public SourceTwo $nested;
}
