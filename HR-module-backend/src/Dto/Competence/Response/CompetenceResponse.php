<?php

namespace App\Dto\Competence\Response;

use App\Dto\Competence\CompetenceDTO;
use App\Dto\Feedback\FeedbackDTO;
use App\Dto\Transformer\Response\AbstractResponceDTOTransformer;
use App\Entity\Competence;
use App\Entity\Feedback;

class CompetenceResponse extends AbstractResponceDTOTransformer
{
    /**
     * @param Competence $object
     */
    public function transformFromObject($object): CompetenceDTO
    {
        $dto = new CompetenceDTO();
        $dto->type = $object->getType();
        $dto->description = $object->getDescription();
        $dto->name = $object->getName();
        $dto->competences_id = [];
        $dto->includes_id = [];
        $dto->skills_id = [];
        $dto->users_id = [];
        $dto->educational_resources = [];
        foreach($object->getCompetences() as $i){
            $dto->competences_id[] = $i->getId();
        }
        foreach($object->getIncludes() as $i){
            $dto->includes_id[] = $i->getId();
        }
        foreach($object->getSkills() as $i){
            $dto->skills_id[] = $i->getId();
        }
        foreach($object->getUsers() as $i){
            $dto->users_id[] = $i->getId();
        }
        foreach($object->getEducationalResources() as $i){
            $dto->educational_resources[] = $i->getId();
        }
        return $dto;
    }
}