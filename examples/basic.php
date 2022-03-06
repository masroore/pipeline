<?php

include 'vendor/autoload.php';

include 'stages.php';

use Kaiju\Pipeline\PipelineBuilder;

$payload = new Payload(10);
$builder = (new PipelineBuilder())
    ->addStage(new TimesTwoStage())
    ->addStage(new AddOneStage());
$pipeline = $builder->build();
$pipeline($payload);
echo 'Value is: ' . $payload->getPayload();
