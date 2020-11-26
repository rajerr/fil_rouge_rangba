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
        $user = $request->request->all();
        $avatar = $request->files->get("avatar");
        $avatar = fopen($avatar->getRealPath(), "rb");
        $user["avatar"] = $avatar;
        $username = $user['username'];
            $user = $serializer->denormalize($user, "App\Entity\Cm");
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
