<?php

namespace App\Enums\Attributes;

use Attribute;

#[Attribute]
class Title
{
    public function __construct(
        public string $title
    ){}

}
