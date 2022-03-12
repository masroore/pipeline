<?php

declare(strict_types=1);

namespace Kaiju\Pipeline;

interface PipelineContextInterface
{
    public function getPayload();

    public function shouldHalt(): bool;

    public function setHalt(bool $halt = true): void;

    /**
     * @param mixed payload
     */
    public function setPayload($payload): void;
}
