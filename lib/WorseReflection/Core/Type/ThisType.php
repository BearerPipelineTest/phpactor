<?php

namespace Phpactor\WorseReflection\Core\Type;

class ThisType extends StaticType
{
    public function __toString(): string
    {
        if ($this->class) {
            return sprintf('$this(%s)', $this->class->__toString());
        }
        return '$this';
    }
}
