<?php

use Kaiju\Pipeline\PipelineContextInterface;
use Kaiju\Pipeline\PipelineStageInterface;
use Kaiju\Pipeline\Traits\HaltablePipeline;

class Payload implements PipelineContextInterface
{
    use HaltablePipeline;

    private int $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }

    public function getPayload(): int
    {
        return $this->value;
    }

    public function setPayload($payload): void
    {
        $this->value = (int) $payload;
    }
}

class TimesTwoStage implements PipelineStageInterface
{
    public function process(PipelineContextInterface $context): void
    {
        $val = (int) $context->getPayload();
        $val *= 2;
        $context->setPayload($val);
    }

    public function id(): string
    {
        return __CLASS__;
    }
}

class AddOneStage implements PipelineStageInterface
{
    public function process(PipelineContextInterface $context): void
    {
        $val = (int) $context->getPayload();
        $val++;
        $context->setPayload($val);
        $context->setHalt(true);
    }

    public function id(): string
    {
        return __CLASS__;
    }
}
