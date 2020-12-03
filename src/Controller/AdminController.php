<?php

namespace App\Controller;

use App\Service\ServiceAddUser;
use App\Repository\AdminRepository;
use App\Repository\ProfileRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use ApiPlatform\Core\Validator\ValidatorInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminController extends AbstractController
{
    /**
     * @Route("/api/admin/admins/{id}", 
     * methods={"delete"},
     *     defaults={
     *         "__controller"="\app\Controller\AdminController::archiver",
     *         "__api_resource_class"=Admin::class,
     *         "__api_collection_operation_name"="archivage"
     *     }
     * )
     */
    public function archiver(AdminRepository $adminrepos, EntityManagerInterface $manager,$id): Response
    {
        $archivage=$adminrepos->find($id);
        $archivage->setStatut(0);
        $manager->persist($archivage);
        $manager->flush();
        return $this->json($archivage,Response::HTTP_OK);
    }

      /**
     * @Route(
     *     path="/api/admin/admins",
     *     methods={"POST"}
     * )
     */
    public function addAdmin(Request $request, ServiceAddUser $serviceAddUser)
    {
        $user = $serviceAddUser->addUser($request, "App\Entity\Admin");

        return  $this->json("Un User Admin enrégistré avec succès");
        

    }

          /**
     * @Route(
     *     path="/api/admin/admins",
     *     methods={"POST"}
     * )
     */
    public function addAdmin(Request $request, ServiceAddUser $serviceAddUser)
    {
        $user = $serviceAddUser->addUser($request, "App\Entity\Admin");

        return  $this->json("Un User Admin enrégistré avec succès");
        

    }
}
