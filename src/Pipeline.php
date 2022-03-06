<?php

declare(strict_types=1);

namespace Kaiju\Pipeline;

class Pipeline implements PipelineInterface
{
    /**
     * @var PipelineStageInterface[]
     */
    private array $_stages;
    private ProcessorInterface $_processor;
    /**
     * @var callable
     */
    private $_progress_cb;

    public function __construct(?ProcessorInterface $processor = null, ?callable $progress_cb = null, PipelineStageInterface ...$stages)
    {
        $this->_progress_cb = $progress_cb;
        $this->_processor = $processor ?? new FingersCrossedProcessor();
        $this->_stages = $stages;
    }

    public function __invoke(PipelineContextInterface $context): PipelineContextInterface
    {
        return $this->process($context);
    }

    public function pipe(PipelineStageInterface $stage): PipelineInterface
    {
        $pipeline = clone $this;
        $pipeline->_stages[] = $stage;

        return $pipeline;
    }

    public function process(PipelineContextInterface $context): PipelineContextInterface
    {
        return $this->_processor->process($context, $this->_progress_cb, ...$this->_stages);
    }
}
