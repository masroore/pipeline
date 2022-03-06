<?php

trait PipelineContext
{
    protected bool $halt = false;

    public function shouldHalt(): bool
    {
        return $this->halt;
    }

    public function setHalt(bool $halt): void
    {
        $this->halt = $halt;
    }
}
