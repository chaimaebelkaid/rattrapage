<?php

namespace App\Controller;

use App\Repository\EntrepriseRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EntrepriseController extends AbstractController
{
    private $entrepriseRepository;

    public function __construct(EntrepriseRepository $entrepriseRepository)
    {
        $this->entrepriseRepository = $entrepriseRepository;
    }

    /**
     * @Route("/entreprise/add/", name="add_entreprise", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $siret = $data['siret'];
        $nom = $data['nom'];
        $adresse = $data['adresse'];
        $cp = $data['cp'];
        $ville = $data['ville'];
        $telephone = $data['telephone'];
        $email = $data['email'];

        if (empty($siret) || empty($nom) || empty($adresse) || empty($cp) || empty($ville) || empty($telephone) || empty($email)) {
            throw new NotFoundHttpException('Expecting mandatory parameters!');
        }

        $this->entrepriseRepository->saveEntreprise($siret, $nom, $adresse, $cp, $ville, $telephone, $email);

        return new JsonResponse(['status' => 'Entreprise created!'], Response::HTTP_CREATED);
    }

    /**
     * @Route("/entreprise/{id}", name="get_one_entreprise", methods={"GET"})
     */
    public function get($id): JsonResponse
    {
        $entreprise = $this->entrepriseRepository->findOneBy(['id' => $id]);

        $data = [
            'id' => $entreprise->getId(),
            'siret' => $entreprise->getSiret(),
            'nom' => $entreprise->getNom(),
            'adresse' => $entreprise->getAdresse(),
            'cp' => $entreprise->getCp(),
            'ville' => $entreprise->getVille(),
            'telephone' => $entreprise->getTelephone(),
            'email' => $entreprise->getEmail()
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/entreprises", name="get_all_entreprises", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        $entreprises = $this->entrepriseRepository->findAll();
        $data = [];

        foreach ($entreprises as $entreprise) {
            $data[] = [
                'id' => $entreprise->getId(),
                'siret' => $entreprise->getSiret(),
                'nom' => $entreprise->getNom(),
                'adresse' => $entreprise->getAdresse(),
                'cp' => $entreprise->getCp(),
                'ville' => $entreprise->getVille(),
                'telephone' => $entreprise->getTelephone(),
                'email' => $entreprise->getEmail()
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/entreprise/update/{id}", name="update_entreprise", methods={"PUT"})
     */
    public function update($id, Request $request): JsonResponse
    {
        $entreprise = $this->entrepriseRepository->findOneBy(['id' => $id]);
        $data = json_decode($request->getContent(), true);

        empty($data['siret']) ? true : $entreprise->setSiret($data['siret']);
        empty($data['nom']) ? true : $entreprise->setNom($data['nom']);
        empty($data['adresse']) ? true : $entreprise->setAdresse($data['adresse']);
        empty($data['cp']) ? true : $entreprise->setCp($data['cp']);
        empty($data['ville']) ? true : $entreprise->setVille($data['ville']);
        empty($data['telephone']) ? true : $entreprise->setTelephone($data['telephone']);
        empty($data['email']) ? true : $entreprise->setEmail($data['email']);


        $updatedEntreprise = $this->entrepriseRepository->updateEntreprise($entreprise);

        return new JsonResponse($updatedEntreprise->toArray(), Response::HTTP_OK);
    }

    /**
     * @Route("/entreprise/delete/{id}", name="delete_entreprise", methods={"DELETE"})
     */
    public function delete($id): JsonResponse
    {
        $entreprise = $this->entrepriseRepository->findOneBy(['id' => $id]);

        $this->entrepriseRepository->removeEntreprise($entreprise);

        return new JsonResponse(['status' => 'Entreprise deleted'], Response::HTTP_OK);
    }

}