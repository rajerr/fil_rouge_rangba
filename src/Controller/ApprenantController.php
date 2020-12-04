<?php

namespace App\Controller;

use App\Service\ServiceAddUser;
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
    public function updateApprenant(int $id, Request $request)
    {
        $data = $request->getContent();
        $users = preg_split("/form-data/", $data);
        unset($users[0]);
        $dat = [];
        foreach($users as $user){
            $delSpace = preg_split("/\n\r/", $user);
            dd($delSpace);
            array_pop($delSpace);
            array_pop($delSpace);
            $a = explode('"', $delSpace[0]);
            $data[$a[1]] = end($delSpace);
            dd($a); 
        }


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
