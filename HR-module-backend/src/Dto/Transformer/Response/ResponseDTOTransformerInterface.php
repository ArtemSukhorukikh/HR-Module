<?php

namespace App\Dto\Transformer\Response;

interface ResponseDTOTransformerInterface
{
    public function transformFromObject($object);
    public function transformFromObjects(iterable $objects): iterable;

}