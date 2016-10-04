<?php
namespace CatalogBundle\Repository;

use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Doctrine\ORM\EntityRepository;
use CatalogBundle\Entity\User;

use Symfony\Component\Form\Form;

class UserRepository extends EntityRepository implements UserLoaderInterface
{
    public function loadUserByUsername($username)
    {
        return $this->createQueryBuilder('u')
            ->where('u.username = :username OR u.email = :email')
            ->setParameter('username', $username)
            ->setParameter('email', $username)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getByPage($page, $per_page, $ordered_by, $direction)
    {
        if ($direction) {
            $directionDQL = 'ASC';
        } else {
            $directionDQL = 'DESC';
        }

        $users = $this
            ->createQueryBuilder('u')
            ->orderBy('u.' . $ordered_by, $directionDQL)
            ->setFirstResult(($page-1)*$per_page)
            ->setMaxResults($per_page)
            ->getQuery()
            ->getResult();


        return $users;
    }


    public function updateDataFromForm(Form $form, User $editable_user)
    {
        $editable_user->setEmail($form->get('email')->getData());
        $editable_user->setIsActive($form->get('is_active')->getData());
        $editable_user->setRole($form->get('role')->getData());
        $this->_em->persist($editable_user);
        $this->_em->flush();
    }
}
