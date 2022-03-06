<p align="center">
  <h3 align="center">Pipeline</h3>
  <p align="center">A PHP package to build multi-staged workflows.</p>
</p>

---

[![Author](https://img.shields.io/badge/author-@masroore-red.svg?style=plastic)](https://twitter.com/masroore)
[![Maintainer](https://img.shields.io/badge/maintainer-@masroore-blue.svg?style=plastic)](https://twitter.com/masroore)


This package provides a pipeline pattern implementation.

## Installation

```sh
$ composer require masroore/pipeline
```

## Pipeline Pattern

The pipeline pattern allows you to easily compose sequential stages by
chaining stages.

In this particular implementation the interface consists of three parts:

* PipelineContextInterface
* PipelineStageInterface
* PipelineInterface

A pipeline consists of one or multiple stages. A pipeline can process 
a payload. During the processing the payload will be passed to the first stage.
From that moment on the resulting value is passed on from stage to stage.

## Concepts

The package has two building blocks to create workflows : Pipeline and Stage and Step . A 
pipeline is a sequential collection of stages.

### The PipelineStageInterface Interface

Stage is the unit of work which can be sequentially executed with other stages. To do that, 
we need to implement the `PipelineStageInterface` interface.

```php
interface PipelineStageInterface
{
    public function id(): string;

    public function process(PipelineContextInterface $context): void;
}
```

To satisfy the interface we need to implement `process()`, `id()` methods in the target type. For e.g:

```php
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
```

The current stage receives a `PipelineContextInterface` value passed on by the previous stage.
The `PipelineContextInterface` type provides a `shouldHalt()` method which can be used to halt pipeline execution.

## Usage

```php
use Kaiju\Pipeline\PipelineBuilder;
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

$payload = new Payload(10);
$builder = (new PipelineBuilder())
    ->addStage(new TimesTwoStage())
    ->addStage(new AddOneStage());
$pipeline = $builder->build();
$pipeline($payload);
echo 'Value is: ' . $payload->getPayload();

```

Check `examples` directory for more.