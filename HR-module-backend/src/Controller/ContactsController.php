<?php

namespace App\Controller;

use App\Dto\AnswearDTO;
use App\Dto\ContactDTO;
use App\Dto\NewContactsDTO;
use App\Dto\Transformer\Request\ContactRequestDTOTransformer;
use App\Dto\Transformer\Response\AnswerResponseDTOTransformer;
use App\Dto\Transformer\Response\ContactResponseDTOTransformer;
use App\Dto\Transformer\Response\UsersContactsResponseDTOTransformer;
use App\Entity\Contacts;
use App\Repository\ContactsRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/v1/contacts')]
class ContactsController extends AbstractController
{
    private $serializer;
    private $validator;
    private ContactResponseDTOTransformer $contactResponseDTOTransformer;
    private UsersContactsResponseDTOTransformer $contactsResponseDTOTransformer;
    private ContactRequestDTOTransformer $contactRequestDTOTransformer;
    private AnswerResponseDTOTransformer $answerResponseDTOTransformer;

    public function __construct(ValidatorInterface $validator,
                                ContactResponseDTOTransformer $contactFromDTOTransformer,
                                UsersContactsResponseDTOTransformer $contactsResponseDTOTransformer,
                                ContactRequestDTOTransformer $contactRequestDTOTransformer,
                                AnswerResponseDTOTransformer $answerResponseDTOTransformer
    )
    {
        $this->serializer = SerializerBuilder::create()->build();
        $this->validator = $validator;
        $this->contactsResponseDTOTransformer = $contactsResponseDTOTransformer;
        $this->contactRequestDTOTransformer = $contactRequestDTOTransformer;
        $this->answerResponseDTOTransformer = $answerResponseDTOTransformer;
    }

    #[Route('/{id}', name: 'app_contacts_user', methods: "GET")]
    public function findContacts($id, UserRepository $userRepository): Response
    {
        $user = $userRepository->find($id);
        $usersContactsDTO = $this->contactsResponseDTOTransformer->transformFromObject($user);
        return $this->json($usersContactsDTO, Response::HTTP_OK);
    }

    #[Route('/new', name: 'app_contacts_new', methods: "POST")]
    public function newContacts(UserRepository $userRepository, Request $request, EntityManagerInterface $entityManager,): Response
    {
        $data = $this->serializer->deserialize($request->getContent(), NewContactsDTO::class, 'json');
        $user = $userRepository->findOneBy(['username' => $data->username]);
        if ($user) {
            $contact = $this->contactRequestDTOTransformer->transformToObject($data);
            $contact->setUserContact($user);
            $entityManager->persist($contact);
            $entityManager->flush();

            return $this->json($data, Response::HTTP_CREATED);
        }

        return $this->json($data, Response::HTTP_BAD_REQUEST);
    }

    #[Route('/update', name: 'app_contacts_update', methods: ["POST", "PUT"])]
    public function updateContacts(ContactsRepository $contactsRepository, Request $request, EntityManagerInterface $entityManager,): Response
    {
        $data = $this->serializer->deserialize($request->getContent(), ContactDTO::class, 'json');
        $contact = $contactsRepository->find($data->id);
        if ($contact) {
            $contact->setlink($data->link);
            $contact->setSource($data->sourse);
            $entityManager->persist($contact);
            $entityManager->flush();
            return $this->json($data, Response::HTTP_CREATED);
        }
        return $this->json($data, Response::HTTP_BAD_REQUEST);
    }
    #[Route('/delete/{id}', name: 'app_contacts_delete', methods: ["POST", "PUT"])]
    public function deleteContacts(int $id, ContactsRepository $contactsRepository, EntityManagerInterface $entityManager,): Response
    {
        $contact = $contactsRepository->find($id);
        if ($contact) {
            $entityManager->remove($contact);
            $entityManager->flush();
            $answer = new AnswearDTO();
            $answer->status = "Deleted";
            $answer->messageAnswear = "Deleted contact";
            return $this->json($answer, Response::HTTP_OK);
        }
        $answer = new AnswearDTO();
        $answer->status = "Un Deleted";
        $answer->messageAnswear = "Contact doent find";
        return $this->json($answer, Response::HTTP_BAD_REQUEST);
    }
}
