<?php

namespace Phpactor\WorseReflection\Core\Type;

use Closure;
use Phpactor\WorseReflection\Core\Trinary;
use Phpactor\WorseReflection\Core\Type;

class CallableType extends PrimitiveType
{
    /**
     * @var Type[]
     */
    public array $args;

    public Type $returnType;

    /**
     * @param Type[] $args
     */
    public function __construct(array $args = [], ?Type $returnType = null)
    {
        $this->args = $args;
        $this->returnType = $returnType ?? new MissingType();
    }

    public function __toString(): string
    {
        return sprintf(
            'callable(%s): %s',
            implode(',', array_map(fn (Type $type) => $type->__toString(), $this->args)),
            $this->returnType->__toString()
        );
    }

    public function toPhpString(): string
    {
        return 'callable';
    }

    public function accepts(Type $type): Trinary
    {
        return Trinary::fromBoolean($type instanceof CallableType);
    }

    public function map(Closure $mapper): Type
    {
        $new = clone $this;
        $new->args = array_map(fn (Type $t) => $t->map($mapper), $this->args);
        $new->returnType = $this->returnType->map($mapper);
        return $new;
    }
}
