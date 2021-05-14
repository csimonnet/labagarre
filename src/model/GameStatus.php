<?php

namespace labagarre\src;

abstract class GameStatus {
    const NOT_INITIALIZED = "not_initialized";
    const INITIALIZED = 'initialized';
    const RUNNING = 'running';
    const OVER = 'over';
}