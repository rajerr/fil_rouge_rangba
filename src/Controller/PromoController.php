<?php

namespace App\Controller;

use DateTime;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PromoController extends AbstractController
{
    /**
     * @Route("api/admin/promo", name="add_promo"),
     * methods={"POST"}
     */
    public function addPromo(): Response
    {
        dd("ok");

        $promo = $request->request->all();
        $avatar = $request->files->get("avatar");
        $avatar = fopen($avatar->getRealPath(), "rb");
        $promo["avatar"] = $avatar;
        $referentiel = $promo['referentiel'];
            $promo = $serializer->denormalize($promo, "App\Entity\Referentiel");
        $errors = $validator->validate($promo);
        if ($errors){
            $errors = $serializer->serialize($errors, "json");
            return new JsonResponse($errors, Response::HTTP_BAD_REQUEST, [], true);
        }
        $promo->setDateDebut(new \DateTime('now'));
        dd($promo);
        $manager->persist($promo);
        $manager->flush();

        return  $this->json($promo, Response::HTTP_CREATED);

        fclose($avatar);
    }

}
