<?php

namespace App\Dto\Transformer\Response;

abstract class AbstractResponceDTOTransformer implements ResponseDTOTransformerInterface
{
    public function transformFromObjects(iterable $objects): iterable
    {
        $dto = [];

        foreach ($objects as $object) {
            $dto[] = $this->transformFromObject($object);
        }
        return $dto;
    }

}