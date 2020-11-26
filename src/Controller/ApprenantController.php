<?php

namespace App\Controller;

use App\Service\ServiceAddUser;
use App\Repository\ApprenantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use ApiPlatform\Core\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ApprenantController extends AbstractController
{
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



    /**
     * @Route(
     *     path="/api/admin/apprenants/{id}",
     *     methods={"PUT"}
     * )
     */
    public function updateApprenant(Request $request,  UserPasswordEncoderInterface $encoder, SerializerInterface $serializer, ValidatorInterface $validator, EntityManagerInterface $manager)
    {
        $user = $request->request->all();
        //dd($user);
        $avatar = $request->files->get("avatar");
        //dd($avatar);
        //dd(json_decode($request->getContent(), true));
        $avatar = fopen($avatar->getRealPath($avatar), "rb");
        $user["avatar"] = $avatar;
        $username = $user['username'];
            $user = $serializer->denormalize($user, "App\Entity\Apprenant");
        $errors = $validator->validate($user);
        if ($errors){
            $errors = $serializer->serialize($errors, "json");
            return new JsonResponse($errors, Response::HTTP_BAD_REQUEST, [], true);
        }
        function randomPassword($length = 10)
        {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }
        $password = randomPassword();
        $user->setPassword($encoder->encodePassword($user, $password));
        $user->setStatut(1);
        $manager->persist($user);
        $manager->flush();
            return  $this->json($user, Response::HTTP_CREATED);
        fclose($avatar);
    }
}
