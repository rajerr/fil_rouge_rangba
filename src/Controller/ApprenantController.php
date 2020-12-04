<?php

namespace App\Controller;

use App\Service\ServiceAddUser;
use App\Repository\ProfileRepository;
use App\Repository\ApprenantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApprenantController extends AbstractController
{
    /**
     * @Route("/api/admin/apprenants/{id}", methods="PUT", name="update_apprenant")
     * 
     */
    public function updateApprenant(int $id, Request $request, ServiceAddUser $serviceAddUser)
    {
        $user = $serviceAddUser->updateUser($id, $request);
        return  $this->json("Un apprenant enrégistré avec succès");

    }


    /**
     * @Route("/api/admin/apprenants/{id}", 
     * methods={"delete"},
     *     defaults={
     *         "__controller"="\app\Controller\ApprenantController::archiver",
     *         "__api_resource_class"=Apprenant::class,
     *         "__api_collection_operation_name"="archivage"
     *     }
     * )
     */
    public function archiver(ApprenantRepository $apprenantrepos, EntityManagerInterface $manager,$id): Response
    {
        $archivage=$apprenantrepos->find($id);
        $archivage->setStatut(0);
        $manager->persist($archivage);
        $manager->flush();
        return $this->json($archivage,Response::HTTP_OK);
    }


    /**
     * @Route(
     *     path="/api/admin/apprenants",
     *     methods={"POST"}
     * )
     */

    public function addApprenant(Request $request, \Swift_Mailer $mailer, ServiceAddUser $serviceAddUser)
    {
        $user = $serviceAddUser->addUser($request, "App\Entity\Apprenant");

        //Envoi de l'Email 
        $message = (new \Swift_Message('Orange Digital Center'))
            ->setFrom('rajerr2013@gmail.com')
            ->setTo($user->getEmail())
            ->setBody("mot de passe est ".$user->getPassword() ," et le username " . $user->getUsername());
        $mailer->send($message);
        
        return  $this->json("Un apprenant enrégistré avec succès");
    }



    
}
