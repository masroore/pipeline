<?php

declare(strict_types=1);

namespace Kaiju\Pipeline;

interface PipelineStageInterface
{
    public function id(): string;

    public function process(PipelineContextInterface $context): void;
}
