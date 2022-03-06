<?php

declare(strict_types=1);

namespace Kaiju\Pipeline;

class FingersCrossedProcessor implements ProcessorInterface
{
    public function process(PipelineContextInterface $context, ?callable $progress_cb, PipelineStageInterface ...$stages): PipelineContextInterface
    {
        foreach ($stages as $stage) {
            $stage->process($context);

            if (null !== $progress_cb) {
                $progress_cb($stage, $context);
            }
        }

        return $context;
    }
}
