<?php

namespace App\Service;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use ApiPlatform\Core\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ServiceAddUser
{
    private $encoder;
    private $serializer;
    private $validator;
    private $manager;

    public function __construct(UserPasswordEncoderInterface $encoder, SerializerInterface $serializer, ValidatorInterface $validator, EntityManagerInterface $manager)
    {
        $this->encoder = $encoder;
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->manager = $manager;

    }
    public function upload($file)
    {
        if($file){
            $avatar = fopen($file->getRealPath(), "rb");
            return $avatar;
        }
        else{
            return null;
        }
    }
    public function hashPassword($user,$password)
    {
        if($user && $password){
            $hashpass=$this->encoder->encodePassword($user, $password);
            return $hashpass ;
        }
        else{
            return null;
        }
    }
        public function randomPassword($length = 10)
            {
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $charactersLength = strlen($characters);
                $randomString = '';
                for ($i = 0; $i < $length; $i++) {
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                }
                return $randomString;
            }

        public function addUser($request, $profile)
        {
            $user = $request->request->all();
            //avatar & error verification
            $avatar = $request->files->get("avatar");
            $avatar = $this->upload($avatar);
            $user["avatar"] = $avatar;
            //random password
            $randomPass=$this->randomPassword();
            $user["password"]=$randomPass;
            //dd($user);
            $user = $this->serializer->denormalize($user,$profile);
            $errors = $this->validator->validate($user);
            if ($errors) {
                $errors = $this->serializer->serialize($errors, "json");
                return new JsonResponse($errors, Response::HTTP_BAD_REQUEST, [], true);
            }
            $this->manager->persist($user);
            $this->manager->flush();
            fclose($avatar);
            return $user;
        }



        public function updateUser($request)
        {
            $user = $request->request->all();
            //dd($user);
            //avatar & error verification
            $avatar = $request->files->get("avatar");
            //dd($avatar);
            $avatar = $this->upload($avatar);
            $user["avatar"] = $avatar;
            //hash password
            $password = $request->request->get("password");
            $user["password"] = $password;
            dd($user["password"]);
            $user->setPassword($encoder->encodePassword($user, $password));
            //dd($user);
            $errors = $this->validator->validate($user);
            if ($errors) {
                $errors = $this->serializer->serialize($errors, "json");
                return new JsonResponse($errors, Response::HTTP_BAD_REQUEST, [], true);
            }
            $this->manager->persist($user);
            $this->manager->flush();
            fclose($avatar);
            return $user;
        }
}