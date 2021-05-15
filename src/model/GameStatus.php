<?php

namespace labagarre\src\model;

abstract class GameStatus {
    const NOT_INITIALIZED = "not_initialized";
    const INITIALIZED = 'initialized';
    const RUNNING = 'running';
    const RUNNING_ROUND = 'running_round';
    const OVER = 'over';
}