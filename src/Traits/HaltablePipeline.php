<?php

declare(strict_types=1);

namespace Kaiju\Pipeline\Traits;

trait HaltablePipeline
{
    protected bool $halt = false;

    public function shouldHalt(): bool
    {
        return $this->halt;
    }

    public function setHalt(bool $halt = true): void
    {
        $this->halt = $halt;
    }
}
