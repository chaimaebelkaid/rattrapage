<?php

namespace App\Repository;

use App\Entity\Entreprise;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Entreprise|null find($id, $lockMode = null, $lockVersion = null)
 * @method Entreprise|null findOneBy(array $criteria, array $orderBy = null)
 * @method Entreprise[]    findAll()
 * @method Entreprise[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntrepriseRepository extends ServiceEntityRepository
{
    private $manager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, Entreprise::class);
        $this->manager = $manager;
    }

    public function saveEntreprise($siret, $nom, $adresse, $cp, $ville, $telephone, $email)
    {
        $newEntreprise = new Entreprise();

        $newEntreprise
            ->setSiret($siret)
            ->setNom($nom)
            ->setAdresse($adresse)
            ->setCp($cp)
            ->setVille($ville)
            ->setTelephone($telephone)
            ->setEmail($email);

        $this->manager->persist($newEntreprise);
        $this->manager->flush();
    }

    public function updateEntreprise(Entreprise $entreprise): Entreprise
    {
        $this->manager->persist($entreprise);
        $this->manager->flush();

        return $entreprise;
    }

    public function removeEntreprise(Entreprise $entreprise)
    {
        $this->manager->remove($entreprise);
        $this->manager->flush();
    }
}