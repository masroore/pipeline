<?php

declare(strict_types=1);

namespace Kaiju\Pipeline;

interface ProcessorInterface
{
    public function process(PipelineContextInterface $context, ?callable $progress_cb, PipelineStageInterface ...$stages): PipelineContextInterface;
}
