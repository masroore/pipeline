<?php

include 'vendor/autoload.php';

include 'stages.php';

use Kaiju\Pipeline\InterruptibleProcessor;
use Kaiju\Pipeline\PipelineBuilder;

$payload = new Payload(10);
$builder = (new PipelineBuilder())
    ->addStage(new TimesTwoStage())
    ->addStage(new TimesTwoStage())
    ->addStage(new AddOneStage())
    ->addStage(new TimesTwoStage());

$pipeline = $builder->build(new InterruptibleProcessor());
$pipeline->process($payload);
echo 'Value is: ' . $payload->getPayload();
