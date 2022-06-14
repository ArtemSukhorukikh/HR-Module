<?php

namespace App\Dto;

use JMS\Serializer\Annotation as Serializer;

class NotificationDTO
{
    #[Serializer\Type("integer")]
    public int $id;
    
    #[Serializer\Type("string")]
    public string $text;
    
    #[Serializer\Type("string")]
    public string $date;

    #[Serializer\Type("string")]
    public string $type;

    #[Serializer\Type("string")]
    public string $department;

    #[Serializer\Type("string")]
    public string $username;

}