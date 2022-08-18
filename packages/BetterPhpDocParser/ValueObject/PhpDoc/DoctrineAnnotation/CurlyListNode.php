<?php

declare(strict_types=1);

namespace Rector\BetterPhpDocParser\ValueObject\PhpDoc\DoctrineAnnotation;

use Rector\BetterPhpDocParser\PhpDoc\ArrayItemNode;
use Stringable;
use Webmozart\Assert\Assert;

final class CurlyListNode extends AbstractValuesAwareNode implements Stringable
{
    /**
     * @param ArrayItemNode[] $arrayItemNodes
     */
    public function __construct(private readonly array $arrayItemNodes = [])
    {
        Assert::allIsInstanceOf($this->arrayItemNodes, ArrayItemNode::class);
        parent::__construct($this->arrayItemNodes);
    }

    public function __toString(): string
    {
        // possibly list items
        return $this->implode($this->values);
    }

//    private function stringifyValue(mixed $value): string
//    {
//        if ($value === false) {
//            return 'false';
//        }
//
//        if ($value === true) {
//            return 'true';
//        }
//
//        if (is_array($value)) {
//            return $this->implode($value);
//        }
//
//        return (string) $value;
//    }

    /**
     * @param mixed[] $array
     */
    private function implode(array $array): string
    {
        $itemContents = '';
        $lastItemKey = array_key_last($array);

        foreach ($array as $key => $value) {
            if (is_int($key)) {
                $itemContents .= (string) $value;
            } else {
                $itemContents .= $key . '=' . (string) $value;
            }

            if ($lastItemKey !== $key) {
                $itemContents .= ', ';
            }
        }

        return '{' . $itemContents . '}';
    }
}
