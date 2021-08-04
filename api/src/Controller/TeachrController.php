<?php

namespace App\Controller;

use App\Entity\Statistics;
use App\Entity\Teachr;
use App\Entity\User;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class TeachrController
 * @package App\Controller
 * @Route ("/api/teachr")
 */
class TeachrController extends AbstractController
{
    /**
     * @Route("/setDb",methods={"POST"})
     * @return Response
     */
    public function setUpDatabase(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $Teachr = $this->getDoctrine()->getRepository("App:Teachr");
        if (count($Teachr->findAll()) <= 0) {
            $teachr1 = new Teachr();
            $teachr1->setPrenom("Caroline Dupont");
            $teachr1->setAvatar("https://randomuser.me/api/portraits/med/women/76.jpg");
            $teachr1->setFormation("Université Paris 8");
            $teachr1->setDescription("Toujours calme et patiente je sais m'adapter aux étudiants");
            $entityManager->persist($teachr1);
            $entityManager->flush();
            $teachr2 = new Teachr();
            $teachr2->setPrenom("Fabien Lefebvre");
            $teachr2->setAvatar("https://randomuser.me/api/portraits/med/men/76.jpg");
            $teachr2->setFormation("Université Paris 8");
            $teachr2->setDescription("Toujours calme et patient je sais m'adapter aux étudiants");
            $entityManager->persist($teachr2);
            $entityManager->flush();
            $teachr3 = new Teachr();
            $teachr3->setPrenom("Julie Saride");
            $teachr3->setAvatar("https://randomuser.me/api/portraits/med/women/75.jpg");
            $teachr3->setFormation("Université Paris 8");
            $teachr3->setDescription("Toujours calme et patiente je sais m'adapter aux étudiants");
            $entityManager->persist($teachr3);
            $entityManager->flush();
            $teachr4 = new Teachr();
            $teachr4->setPrenom("Fabrice Satin");
            $teachr4->setAvatar("https://randomuser.me/api/portraits/med/men/75.jpg");
            $teachr4->setFormation("Université Paris 8");
            $teachr4->setDescription("Toujours calme et patient je sais m'adapter aux étudiants");
            $entityManager->persist($teachr4);
            $entityManager->flush();
            $teachr5 = new Teachr();
            $teachr5->setPrenom("Sarah Jouvence");
            $teachr5->setAvatar("https://randomuser.me/api/portraits/med/women/54.jpg");
            $teachr5->setFormation("Université Paris 8");
            $teachr5->setDescription("Toujours calme et patiente je sais m'adapter aux étudiants");
            $entityManager->persist($teachr5);
            $entityManager->flush();
            $teachr6 = new Teachr();
            $teachr6->setPrenom("Damien Dubois");
            $teachr6->setAvatar("https://randomuser.me/api/portraits/med/men/54.jpg");
            $teachr6->setFormation("Université Paris 8");
            $teachr6->setDescription("Toujours calme et patient je sais m'adapter aux étudiants");
            $entityManager->persist($teachr6);
            $entityManager->flush();
            $teachr7 = new Teachr();
            $teachr7->setPrenom("Aurélie Durand");
            $teachr7->setAvatar("https://randomuser.me/api/portraits/med/women/51.jpg");
            $teachr7->setFormation("Université Paris 8");
            $teachr7->setDescription("Toujours calme et patiente je sais m'adapter aux étudiants");
            $entityManager->persist($teachr7);
            $entityManager->flush();
            $teachr8 = new Teachr();
            $teachr8->setPrenom("Didier Leroy");
            $teachr8->setAvatar("https://randomuser.me/api/portraits/med/men/51.jpg");
            $teachr8->setFormation("Université Paris 8");
            $teachr8->setDescription("Toujours calme et patient je sais m'adapter aux étudiants");
            $entityManager->persist($teachr8);
            $entityManager->flush();
            $teachr9 = new Teachr();
            $teachr9->setPrenom("Amélie Deschamps");
            $teachr9->setAvatar("https://randomuser.me/api/portraits/med/women/50.jpg");
            $teachr9->setFormation("Université Paris 8");
            $teachr9->setDescription("Toujours calme et patiente je sais m'adapter aux étudiants");
            $entityManager->persist($teachr9);
            $entityManager->flush();
            $teachr10 = new Teachr();
            $teachr10->setPrenom("Thomas Houx");
            $teachr10->setAvatar("https://randomuser.me/api/portraits/med/men/50.jpg");
            $teachr10->setFormation("Université Paris 8");
            $teachr10->setDescription("Toujours calme et patient je sais m'adapter aux étudiants");
            $entityManager->persist($teachr10);
            $entityManager->flush();
            $user = new User();
            $user->setPrenom('Didier');
            $entityManager->persist($user);
            $entityManager->flush();

            return new Response('Base de données rempli');
        } else {
            return new Response('Base de données déjà rempli');
        }
    }


    /**
     * @Route("/list" ,methods={"GET"})
     * @return Response
     * @throws NonUniqueResultException
     */
    public function list(): Response
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);

        $teachrsQuery = $this->getDoctrine()
            ->getRepository("App:Teachr")
            ->findAll();
        $teachrs = [];

        foreach ($teachrsQuery as $teachr) {
            $teachrData = new \stdClass();
            $teachrData->id = $teachr->getId();
            $teachrData->prenom = $teachr->getPrenom();
            $teachrData->formation = $teachr->getFormation();
            $teachrData->description = $teachr->getDescription();
            $teachrData->photo = $teachr->getAvatar();
            $teachrData->cree_le = $teachr->getCreatedAt()->format('d/m/Y \à H:i');
            $users = $this->getDoctrine()
                ->getRepository("App:User")
                ->findAll();

            $user = $this->getDoctrine()
                ->getRepository('App:User')
                ->findOneById(1);
            $favoris = $user->getTeachrsFavoris();
            if (in_array($teachr->getId(), $favoris)) {
                $teachrData->isFavoris = true;
            } else {
                $teachrData->isFavoris = false;
            }
            array_push($teachrs, $teachrData);
        }

        $teachrs = $serializer->serialize($teachrs, 'json');
        $response = new Response($teachrs);
        $response->headers->set("Content-Type", "application/json");

        return $response;
    }

    /**
     * @Route("/create" ,methods={"POST"})
     * @param ValidatorInterface $validator
     * @return JsonResponse
     * @throws NonUniqueResultException
     */
    public function create(ValidatorInterface $validator): JsonResponse
    {
        $request = Request::CreateFromGlobals();
        $body = json_decode($request->getContent(), true);

        if (!empty($body)) {
            if (!array_key_exists("prenom", $body) || !array_key_exists("formation", $body) || !array_key_exists("description", $body)) {
                return new JsonResponse([
                    "success" => false,
                    "data" => "Invalid Body ici"
                ], 404);
            } else {
                $teachr = new Teachr();
                $teachr->setPrenom($body["prenom"]);
                $teachr->setFormation($body["formation"]);
                $teachr->setDescription($body["description"]);
            }
        } else {
            return new JsonResponse([
                "success" => false,
                "data" => "Invalid Body"
            ], 404);
        }


        $entityManager = $this->getDoctrine()->getManager();

        $errors = $validator->validate($teachr);
        if (count($errors) > 0) {
            return new JsonResponse([
                "success" => false,
                "data" => (string)$errors
            ]);
        } else {
            $stats = $this->getDoctrine()
                ->getRepository("App:Statistics")
                ->findOneById(0);
            if (!empty($stats)) {
                $nbrDeTeachr = $stats->getNbrDeTeachrs();
                $stats->setNbrDeTeachrs($nbrDeTeachr++);
            } else {
                $stats = new Statistics();
            }

            $entityManager->persist($teachr);
            $entityManager->persist($stats);
            $entityManager->flush();
            return new JsonResponse([
                "success" => true,
                "data" => [
                    "id" => $teachr->getId(),
                    "prenom" => $teachr->getPrenom(),
                    "formation" => $teachr->getFormation(),
                    "description" => $teachr->getDescription(),
                    "photo" => $teachr->getAvatar(),
                    "créé le" => $teachr->getCreatedAt()->format('d/m/Y \à H:i')
                ]
            ]);
        }


    }

    /**
     * @Route ("/favoris/{idClient}", methods={"PUT"})
     * @param int $idClient
     * @return Response
     * @throws NonUniqueResultException
     */
    public function getFavoris(int $idClient): Response
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);
        $user = $this->getDoctrine()
            ->getRepository('App:User')
            ->findOneById($idClient);
        $favoris = $user->getTeachrsFavoris();
        $teachrs = [];
        foreach ($favoris as $id) {
            $teachr = $this->getDoctrine()->getRepository("App:Teachr")->findOneById($id);

            if (!empty($teachr)) {
                $teachrData = new \stdClass();
                $teachrData->id = $teachr->getId();
                $teachrData->prenom = $teachr->getPrenom();
                $teachrData->formation = $teachr->getFormation();
                $teachrData->description = $teachr->getDescription();
                $teachrData->photo = $teachr->getAvatar();
                $teachrData->cree_le = $teachr->getCreatedAt()->format('d/m/Y \à H:i');
                $teachrData->isFavoris = true;
                array_push($teachrs, $teachrData);
            }
        }
        $teachrs = $serializer->serialize($teachrs, 'json');
        $response = new Response($teachrs);
        $response->headers->set("Content-Type", "application/json");

        return $response;
    }

    /**
     * @Route ("/delFavoris/{idClient}", methods={"POST"})
     * @param $idClient
     * @return JsonResponse
     * @throws NonUniqueResultException
     */
    public function removeFavoris($idClient): JsonResponse
    {
        $request = Request::CreateFromGlobals();
        $body = json_decode($request->getContent(), true);
        if (!empty($body)) {
            if (!array_key_exists("idTeachr", $body)) {
                return new JsonResponse([
                    "success" => false,
                    "data" => "Invalid Body"
                ], 404);
            } else {
                $idTeachr = $body['idTeachr'];
                $user = $this->getDoctrine()
                    ->getRepository('App:User')
                    ->findOneById($idClient);
                $favoris = $user->getTeachrsFavoris();
                if (in_array($idTeachr, $favoris)) {
                    if (($key = array_search($idTeachr, $favoris)) !== false) {
                        unset($favoris[$key]);
                        $user->setTeachrsFavoris($favoris);
                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->persist($user);
                        $entityManager->flush();
                        return new JsonResponse([
                            "success" => true,
                            "data" => "Teachr removed successfully"
                        ]);
                    } else {
                        return new JsonResponse([
                            "success" => false,
                            "data" => "Invalid Body"
                        ], 404);
                    }
                } else {
                    return new JsonResponse([
                        "success" => false,
                        "data" => "Invalid Body"
                    ], 404);
                }
            }
        } else {
            return new JsonResponse([
                "success" => false,
                "data" => "Invalid Body"
            ], 404);
        }

    }

    /**
     * @Route ("/addFavoris/{idClient}", methods={"POST"})
     * @param $idClient
     * @return JsonResponse
     * @throws NonUniqueResultException
     */
    public function addFavoris($idClient): JsonResponse
    {
        $request = Request::CreateFromGlobals();
        $body = json_decode($request->getContent(), true);
        if (!empty($body)) {
            if (!array_key_exists("idTeachr", $body)) {
                return new JsonResponse([
                    "success" => false,
                    "data" => "Invalid Body"
                ], 404);
            } else {
                $idTeachr = $body['idTeachr'];
                $user = $this->getDoctrine()
                    ->getRepository('App:User')
                    ->findOneById($idClient);
                $favoris = $user->getTeachrsFavoris();
                if (!in_array($idTeachr, $favoris)) {
                    array_push($favoris, $idTeachr);
                    $user->setTeachrsFavoris($favoris);
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($user);
                    $entityManager->flush();
                    return new JsonResponse([
                        "success" => true,
                        "data" => "Teachr added successfully"
                    ]);
                } else {
                    return new JsonResponse([
                        "success" => false,
                        "data" => "Invalid Body"
                    ], 404);
                }
            }
        } else {
            return new JsonResponse([
                "success" => false,
                "data" => "Invalid Body"
            ], 404);
        }

    }

}
