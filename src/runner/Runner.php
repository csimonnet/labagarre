<?php

namespace labagarre\src\runner;

interface Runner {

    public function init(array $players);

    public function isComplete(): bool;

    public function nextStep();

    public function end();

    public function getWinners();

    public function getStatus();

}