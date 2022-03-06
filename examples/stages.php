<?php

use Kaiju\Pipeline\PipelineContextInterface;
use Kaiju\Pipeline\PipelineStageInterface;

class Payload implements PipelineContextInterface
{
    private int $value;
    private bool $halt;

    public function __construct(int $value)
    {
        $this->value = $value;
        $this->halt = false;
    }

    public function shouldHalt(): bool
    {
        return $this->halt;
    }

    public function setHalt(bool $halt): void
    {
        $this->halt = $halt;
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
