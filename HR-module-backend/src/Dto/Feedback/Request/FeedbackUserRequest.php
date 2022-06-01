<?php

namespace App\Dto\Feedback\Request;

use App\Dto\Feedback\FeedbackUserDTO;
use App\Dto\Transformer\Request\AbstractRequestDTOTransformer;
use App\Entity\Feedback;
use App\Entity\User;
use App\Entity\EducationalResources;

class FeedbackUserRequest extends AbstractRequestDTOTransformer
{
    /**
     * @param FeedbackUserDTO $object
     */
    public function transformToObject($object)
    {
        $data = new Feedback();
        return $data;
    }
}