<?php

namespace App\Controller;

use App\Dto\UserCurrentDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Security as SecurityOA;

#[Route('/api/v1/users')]
class ApiUserController extends AbstractController
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
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
        $currentUser = new UserCurrentDto();
        $currentUser->username = $user->getUserIdentifier();
        $currentUser->roles = $user->getRoles();
        return $this->json($currentUser, Response::HTTP_OK);
    }

}
