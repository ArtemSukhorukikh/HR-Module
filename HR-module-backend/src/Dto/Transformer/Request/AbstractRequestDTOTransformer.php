<?php

namespace App\Dto\Transformer\Request;

abstract class AbstractRequestDTOTransformer implements RequestDTOTransformerInterface
{
    public function transformToObjects(iterable $objects): iterable
    {
        $dto = [];

        foreach ($objects as $object) {
            $dto[] = $this->transformToObject($object);
        }
        return $dto;
    }

}