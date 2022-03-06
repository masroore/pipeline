<?php

declare(strict_types=1);

namespace Kaiju\Pipeline;

final class PipelineBuilder
{
    /**
     * @var PipelineStageInterface[]
     */
    private array $_stages = [];
    /**
     * @var ?callable|?Closure
     */
    private $_cb;

    public function addStage(PipelineStageInterface $stage): self
    {
        $this->_stages[] = $stage;

        return $this;
    }

    public function setProgressCallback(callable $callback): self
    {
        $this->_cb = $callback;

        return $this;
    }

    public function build(?ProcessorInterface $processor = null): PipelineInterface
    {
        return new Pipeline($processor, $this->_cb, ...$this->_stages);
    }
}
