<?php

namespace App\Controller;

use App\Dto\OfficeDTO;
use App\Dto\Transformer\Request\OfficeRequestDTOTransformer;
use App\Dto\Transformer\Request\WorkplaceRequestDTOTransformer;
use App\Dto\Transformer\Response\OfficesFullResponseDTOTransformer;
use App\Dto\UserDto;
use App\Dto\WorkplaceDTO;
use App\Entity\Office;
use App\Repository\OfficeRepository;
use App\Repository\UserRepository;
use App\Repository\WorkplaceRepository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

#[Route('/api/v1/offices')]
class OfficeController extends AbstractController
{
    private OfficesFullResponseDTOTransformer $fullResponseDTOTransformer;
    private OfficeRequestDTOTransformer $officeRequestDTOTransformer;
    private WorkplaceRequestDTOTransformer $workplaceRequestDTOTransformer;
    private Security $security;

    public function __construct(OfficesFullResponseDTOTransformer $fullResponseDTOTransformer,
                                OfficeRequestDTOTransformer $officeRequestDTOTransformer,
                                WorkplaceRequestDTOTransformer $workplaceRequestDTOTransformer,
                                Security $security)
    {
        $this->serializer = SerializerBuilder::create()->build();
        $this->fullResponseDTOTransformer = $fullResponseDTOTransformer;
        $this->officeRequestDTOTransformer = $officeRequestDTOTransformer;
        $this->workplaceRequestDTOTransformer = $workplaceRequestDTOTransformer;
        $this->security = $security;
    }

    #[Route('/', name: 'app_office_full', methods: "GET")]
    public function getOfficecFull(OfficeRepository $officeRepository,
                                   WorkplaceRepository $workplaceRepository)
    : Response
    {
        $allOffices = $officeRepository->findAll();
        if ($allOffices) {
            $data = $this->fullResponseDTOTransformer->transformFromObject($allOffices);
            return $this->json($data, Response::HTTP_OK);
        }
    }

    #[Route('/new', name: 'app_office_new', methods: "POST")]
    public function newOffice(Request $request, EntityManagerInterface $entityManager)
    : Response
    {
        $officeDto = $this->serializer->deserialize($request->getContent(), OfficeDTO::class, 'json');
        if ($officeDto) {
            $officeNew = $this->officeRequestDTOTransformer->transformToObject($officeDto);
            $entityManager->persist($officeNew);
            $entityManager->flush();
            return $this->json($officeDto, Response::HTTP_CREATED);
        }
    }

    #[Route('/new/workplace/{id}', name: 'app_office_new_workplace', methods: "POST")]
    public function newWorkplace(int $id, Request $request, EntityManagerInterface $entityManager, OfficeRepository $officeRepository)
    : Response
    {
        $workplaceDto = $this->serializer->deserialize($request->getContent(), WorkplaceDTO::class, 'json');
        $office = $officeRepository->find($id);
        if ($workplaceDto && $office) {
            $workplaceNew = $this->workplaceRequestDTOTransformer->transformToObject($workplaceDto);
            $workplaceNew->setOffice($office);
            $entityManager->persist($workplaceNew);
            $entityManager->flush();
            return $this->json($workplaceDto, Response::HTTP_CREATED);
        }
    }

    #[Route('/set/workplace/{id}', name: 'app_office_add_user', methods: "POST")]
    public function setWorkplace(int $id, Request $request, UserRepository $userRepository, EntityManagerInterface $entityManager, WorkplaceRepository $workplaceRepository)
    : Response
    {
        $username = $request->toArray()['username'];
        $user = $this->security->getUser();
        if (!$user) {
            return $this->json([
                'status_code' => Response::HTTP_UNAUTHORIZED,
                'message' => 'User is not authenticated.'
            ], Response::HTTP_UNAUTHORIZED);
        }
        $user = $userRepository->findOneBy(['username' => $username]);
        if ($workplaceRepository->findOneBy(['userInWorkplace'=>$user->getId()]))
        {
            return $this->json([
                'status_code' => Response::HTTP_BAD_REQUEST,
                'message' => 'User have got a placework.'
            ], Response::HTTP_BAD_REQUEST);
        }
        $workplace = $workplaceRepository->find($id);
        if ($workplace->getUserInWorkplace() !== null) {
            return $this->json([
                'status_code' => Response::HTTP_BAD_REQUEST,
                'message' => 'WorkPlace is busy.'
            ], Response::HTTP_BAD_REQUEST);
        }
        if ($user && $workplace) {
            $workplace->setUserInWorkplace($user);
            $entityManager->persist($workplace);
            $entityManager->flush();
            return $this->json(["status" => "OK"], Response::HTTP_CREATED);
        }
    }

    #[Route('/unset/workplace/{id}', name: 'app_office_unset_user', methods: "POST")]
    public function unsetWorkplace(int $id, Request $request, UserRepository $userRepository, EntityManagerInterface $entityManager, WorkplaceRepository $workplaceRepository)
    : Response
    {
        $user = $this->security->getUser();
        if (!$user) {
            return $this->json([
                'status_code' => Response::HTTP_UNAUTHORIZED,
                'message' => 'User is not authenticated.'
            ], Response::HTTP_UNAUTHORIZED);
        }
        $workplace = $workplaceRepository->find($id);
        if ($workplace) {
            $workplace->getUserInWorkplace()->setWorkplace(null);
            $entityManager->persist($workplace);
            $entityManager->flush();
            return $this->json(["status" => "OK"], Response::HTTP_CREATED);

        }
        return $this->json(['doen`t find'], Response::HTTP_BAD_REQUEST);
    }

}
