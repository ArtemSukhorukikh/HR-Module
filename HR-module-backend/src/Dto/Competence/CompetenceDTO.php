<?php

namespace App\Dto\Competence;

use JMS\Serializer\Annotation as Serializer;

class CompetenceDTO
{
    #[Serializer\Type("integer")]
    public int $id;

    #[Serializer\Type("string")]
    public string $name;

    #[Serializer\Type("string")]
    public string $description;

    #[Serializer\Type("array<integer>")]
    public array $educational_resources;

    #[Serializer\Type("array<integer>")]
    public array $includes_id;

    #[Serializer\Type("array<integer>")]
    public array $competences_id;

    #[Serializer\Type("array<integer>")]
    public array $skills_id;

    #[Serializer\Type("array<integer>")]
    public array $users_id;

    #[Serializer\Type("integer")]
    public int $type;

}