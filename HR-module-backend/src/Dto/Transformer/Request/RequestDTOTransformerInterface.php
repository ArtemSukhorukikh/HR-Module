<?php

namespace App\Dto\Transformer\Request;

interface RequestDTOTransformerInterface
{
    public function transformToObject($object);
    public function transformToObjects(iterable $objects): iterable;

}