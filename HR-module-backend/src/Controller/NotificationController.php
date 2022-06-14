<?php

namespace App\Controller;

use App\Dto\NotificationDTO;
use App\Dto\Transformer\Request\GradeRequestDTOTransformer;
use App\Dto\Transformer\Request\NotificationRequestDTOTransformer;
use App\Dto\Transformer\Response\GradesUserResponseDTOTransformer;
use App\Dto\Transformer\Response\NotificationResponseDTOTransformer;
use App\Repository\DepartmentRepository;
use App\Repository\NotificationRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
#[Route('/api/v1', name: 'app_notification_add')]
class NotificationController extends AbstractController
{
    public NotificationResponseDTOTransformer $notificationResponseDTOTransformer;
    public NotificationRequestDTOTransformer $notificationRequestDTOTransformer;
    private $serializer;
    private Security $security;
    public function __construct(NotificationResponseDTOTransformer $notificationResponseDTOTransformer,
                                NotificationRequestDTOTransformer $notificationRequestDTOTransformer,
                                Security $security)
    {
        $this->security = $security;
        $this->serializer = SerializerBuilder::create()->build();
        $this->notificationResponseDTOTransformer = $notificationResponseDTOTransformer;
        $this->notificationRequestDTOTransformer = $notificationRequestDTOTransformer;
    }
    #[Route('/notification/new', name: 'app_notification_add')]
    public function new(Request $request,
                        EntityManagerInterface $entityManager,
                        UserRepository $userRepository,
                        DepartmentRepository $departmentRepository): Response
    {
        $notificationDTO = $this->serializer->deserialize($request->getContent(), NotificationDTO::class, 'json');
        $notification = $this->notificationRequestDTOTransformer->transformToObject($notificationDTO);
        if ($notificationDTO->type === "All") {
            $users = $userRepository->findAll();
            foreach ($users as $user) {
                $user->addNotification($notification);
            }
            $entityManager->persist($notification);
            $entityManager->flush();
            return $this->json(['ok'], Response::HTTP_OK);
        } else if ($notificationDTO->type === "Department") {
            $department = $departmentRepository->findOneBy(['name'=>$notificationDTO->department]);
            if ($department) {
                foreach ($department->getUsers() as $user) {
                    $user->addNotification($notification);
                }
                $entityManager->persist($notification);
                $entityManager->flush();
                return $this->json(['ok'], Response::HTTP_OK);
            }
        } else if ($notificationDTO->type === "User") {
            $user = $userRepository->findOneBy(["username" => $notificationDTO->username]);
            if ($user) {
                $user->addNotification($notification);
                $entityManager->persist($notification);
                $entityManager->flush();
                return $this->json(['ok'], Response::HTTP_OK);
            }
        }
        return $this->json(['Bad data'], Response::HTTP_BAD_REQUEST);
    }

    #[Route('/notification/all', name: 'app_notification_all')]
    public function all(NotificationRepository $repository): Response
    {
       return $this->json($this->notificationResponseDTOTransformer->transformFromObjects($repository->findAll()),Response::HTTP_OK);
    }

    #[Route('/notification/delete/{id}', name: 'app_notification_all')]
    public function delete(int $id, NotificationRepository $repository, EntityManager $entityManager): Response
    {
        $notification = $repository->find($id);
        if ($notification) {
            $entityManager->remove($notification);
            $entityManager->flush();
            return $this->json(['Ok', Response::HTTP_BAD_REQUEST]);
        } else {
            return $this->json(['Doesn`t find'], Response::HTTP_BAD_REQUEST);
        }
    }
}
