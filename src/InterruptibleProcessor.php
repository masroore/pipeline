<?php

declare(strict_types=1);

namespace Kaiju\Pipeline;

class InterruptibleProcessor implements ProcessorInterface
{
    public function process(PipelineContextInterface $context, ?callable $progress_cb, PipelineStageInterface ...$stages): PipelineContextInterface
    {
        foreach ($stages as $stage) {
            $stage->process($context);

            if (null !== $progress_cb) {
                $progress_cb($stage, $context);
            }

            if ($context->shouldHalt()) {
                return $context;
            }
        }

        return $context;
    }
}
