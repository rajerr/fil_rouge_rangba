<?php

namespace App\Controller;

use App\Service\ServiceAddUser;
use App\Repository\CmRepository;
use App\Repository\FormateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use ApiPlatform\Core\Validator\ValidatorInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CmController extends AbstractController
{
    /**
     * @Route("/api/admin/cms/{id}/archivage", 
     * methods={"PUT"},
     *     defaults={
     *         "__controller"="\app\Controller\CmController::archiver",
     *         "__api_resource_class"=Cm::class,
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
     *     path="/api/admin/cms",
     *     methods={"POST"}
     * )
     */
    public function addComManager(Request $request, ServiceAddUser $serviceAddUser)
    {
        $user = $serviceAddUser->addUser($request, "App\Entity\Cm");

        return  $this->json($user, Response::HTTP_CREATED);
    }
}
