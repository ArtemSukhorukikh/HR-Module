<?php

namespace App\Controller;

use App\Dto\Transformer\Response\UserResponseDTOTransformer;
use App\Dto\UserCurrentDto;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Security as SecurityOA;

#[Route('/api/v1/users')]
class ApiUserController extends AbstractController
{
    private Security $security;
    public UserResponseDTOTransformer $userResponseDTOTransformer;

    public function __construct(Security $security,
                                UserResponseDTOTransformer $userResponseDTOTransformer)
    {
        $this->security = $security;
        $this->userResponseDTOTransformer = $userResponseDTOTransformer;
    }
    /**
     * @OA\Get(
     *     path="api/v1/users/current",
     *     description="Get current user",
     * )
     * @OA\Response(
     *     response=200,
     *     description="Returns information about current user",
     *     @OA\JsonContent(
     *        @OA\Property(
     *          property="username",
     *          type="string",
     *        ),
     *        @OA\Property(
     *          property="roles",
     *          type="array",
     *          @OA\Items(type="string")
     *        ),
     *        @OA\Property(
     *          property="balance",
     *          type="float",
     *        )
     *     )
     * )
     * @OA\Response(
     *     response=401,
     *     description="User is not authenticated",
     *     @OA\JsonContent(
     *        @OA\Property(
     *          property="code",
     *          type="string"
     *        ),
     *        @OA\Property(
     *          property="message",
     *          type="string"
     *        ),
     *     )
     * )
     * @OA\Response(
     *     response="default",
     *     description="Unxepected error",
     *     @OA\JsonContent(
     *        @OA\Property(
     *          property="code",
     *          type="string"
     *        ),
     *        @OA\Property(
     *          property="message",
     *          type="string"
     *        ),
     *     )
     * )
     * @SecurityOA(name="Bearer")
     */
    #[Route('/current', name: 'current_user', methods: ['GET'])]
    public function getCurrentUser(): Response
    {
        $user = $this->security->getUser();
        if (!$user) {
           $this->json([
           'status_code' => Response::HTTP_UNAUTHORIZED,
           'message' => 'User is not authenticated.'
           ], Response::HTTP_UNAUTHORIZED);
        }
        $currentUser = $this->userResponseDTOTransformer->transformFromObject($user);
        return $this->json($currentUser, Response::HTTP_OK);
    }

    #[Route('/search', name: 'user_search', methods: ['GET'])]
    public function getUserSearch(Request $request, UserRepository $userRepository): Response
    {
        $user = $userRepository->findOneBy(['username' => $request->toArray()['username']]);
        if (!$user) {
            $this->json([
                'status_code' => Response::HTTP_BAD_REQUEST,
                'message' => 'User is not find.'
            ], Response::HTTP_UNAUTHORIZED);
        }
        $currentUser = $this->userResponseDTOTransformer->transformFromObject($user);
        return $this->json($currentUser, Response::HTTP_OK);
    }

}
