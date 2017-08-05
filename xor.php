<?php
require_once(__DIR__ . '/autoload.php');

use Logging\LogLevelEnum;
use Logging\Logger;
use Train\Train;
use Layers\Layer;
use Train\TrainNumbers;

const EXPECTATIONS = [
    [
        'expected' => 0,
        'input' => [0, 0]
    ],
    [
        'expected' => 1,
        'input' => [1, 0]
    ],
    [
        'expected' => 1,
        'input' => [0, 1]
    ],
    [
        'expected' => 0,
        'input' => [1, 1]
    ]
];


Logger::setLevel(LogLevelEnum::DEBUG);

$network = new Net;

set_exception_handler(function($e) use($network) {
    println($e->getMessage());

    /** @var Layer $layer */
    foreach ($network->getLayers() as $layer) {
        println("Describing layer type: {$layer->getType()}");

        /** @var Neuron $node */
        foreach ($layer->getNodes() as $node) {
            println("Node as value of: {$node->getOutputVal()}", 1);
        }
    }
});

/*
 * Training phase
 */

$train = new Train('xor');
$topology = $train->getTopology();

$network->setup($topology);

$train->setNetwork($network)
    ->train();



foreach (EXPECTATIONS as $expectation) {
    $network->feedForward($expectation['input']);
    $results = $network->getResults();

    $result = array_pop($results);

    println("Result: {$result}; Expected: {$expectation['expected']};");

    $pass = abs($expectation['expected'] - $result) < 0.1 ? "pass" : "fail";

    println("Outcome: {$pass}");

}

