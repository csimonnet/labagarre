<?php

namespace labagarre\src\model;

class Card
{
    //la classe peut paraître superflue de prime abord, ce sera néanmoins utile si par exemple on
    //veut lui ajouter un nom ou un type (par exemple préciser que c'est un roi, un sept de carreau, etc...)
    protected int $value;

    public function __construct(int $value) {
        $this->value = $value;
    }

    public function getValue(): int {
        return $this->value;
    }

}