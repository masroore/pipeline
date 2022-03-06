<?php

declare(strict_types=1);

namespace Kaiju\Pipeline;

interface PipelineInterface
{
    public function pipe(PipelineStageInterface $stage): self;

    public function process(PipelineContextInterface $context): PipelineContextInterface;
}
