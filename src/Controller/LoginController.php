<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Firebase\JWT\JWT;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class LoginController extends AbstractController
{
    private $userRepository;
    private $userPasswordEncoder;

    public function __construct(
        UserRepository $userRepository,
        UserPasswordEncoderInterface $userPasswordEncoder
    ) {
        $this->userRepository = $userRepository;
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    public function index(Request $r): Response
    {
        try {
            $dataReq = json_decode($r->getContent());
            
            $user = $this->userRepository->findOneBy([
                'username' => $dataReq->username
            ]);

            if(!$this->userPasswordEncoder->isPasswordValid($user, $dataReq->password))
            {
                return new JsonResponse([
                    'success' => false,
                    'message' => 'Password informado está incorreto.'
                ], Response::HTTP_BAD_REQUEST);
            }

            $appToken = JWT::encode(['username' => $user->getUsername()], '$0kt&7ttDefG44', 'HS256');

            return new JsonResponse([
                'success' => true,
                'api_token' => $appToken
            ], Response::HTTP_OK);

        } catch (\ErrorException $e) {
            return new JsonResponse([
                'success' => false,
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        } catch (\Throwable $th) {
            dd($th);
        }
        
    }
}
