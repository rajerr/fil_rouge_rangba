<?php

namespace App\Controller;

use App\Service\ServiceAddUser;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use ApiPlatform\Core\Validator\ValidatorInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class FormateurController extends AbstractController
{
    /**
     * @Route("/api/admin/formateurs/{id}/archivage", 
     * methods={"PUT"},
     *     defaults={
     *         "__controller"="\app\Controller\FormateurController::archiver",
     *         "__api_resource_class"=Formateur::class,
     *         "__api_collection_operation_name"="archivage"
     *     }
     * )
     */
    public function archiver(CmRepository $cmrepos, EntityManagerInterface $manager,$id): Response
    {
        $archivage=$cmrepos->find($id);
        $archivage->setStatut(0);
        $manager->persist($archivage);
        $manager->flush();
        return $this->json($archivage,Response::HTTP_OK);
    }

      /**
     * @Route(
     *     path="/api/admin/formateurs",
     *     methods={"POST"}
     * )
     */
    public function addFormateur(Request $request,  ServiceAddUser $serviceAddUser)
    {
        $user = $serviceAddUser->addUser($request, "App\Entity\Formateur");

        return  $this->json($user, Response::HTTP_CREATED);
    }
}
