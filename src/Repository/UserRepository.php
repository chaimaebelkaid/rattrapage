<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    private $manager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, User::class);
        $this->manager = $manager;

    }
    public function saveUser($email, $roles, $password)
    {
        $newUser = new User();

        $newUser
            ->setEmail($email)
            ->setRoles($roles)
            ->setPassword($password);

        $this->manager->persist($newUser);
        $this->manager->flush();
    }

    public function updateUser(User $User): User
    {
        $this->manager->persist($User);
        $this->manager->flush();

        return $User;
    }

    public function removeUser(User $User)
    {
        $this->manager->remove($User);
        $this->manager->flush();
    }
}
