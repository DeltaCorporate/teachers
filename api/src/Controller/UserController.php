<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("api/user", name="user")
 */
class UserController extends AbstractController
{
    /**
     * @Route ("/createFakeUsers",methods={"POST"})
     * @return Response
     */
    public function createFakeUsers(): Response
    {
        $entityManager = $this->getDoctrine()
            ->getManager();
        $user = new User();
        $user->setPrenom('Didier');

        $entityManager->persist($user);
        $entityManager->flush();
        $user = new User();
        $user->setPrenom('Fabien');
        $user->setTeachrsFavoris([1, 2]);
        $entityManager->persist($user);
        $entityManager->flush();
        return new Response("Created fake users");
    }

    /**
     * @Route("/login", methods={"POST"})
     * @return Response
     * @throws NonUniqueResultException
     */
    public function login(): Response
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);

        $user = $this->getDoctrine()->getRepository("App:User")->findOneByPrenom("Fabien");
        $user = $serializer->serialize($user, 'json');
        $response = new Response($user);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

}
