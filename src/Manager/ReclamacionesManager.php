<?php

namespace App\Manager;

use App\Entity\Reclamacion;
use App\Entity\Usuario;
use App\Exception\SchoolException;
use Doctrine\ORM\EntityManager;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class ReclamacionesManager
{
    private $em;




    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;

    }

    public function findAll(){
        return $this->em->getRepository(Reclamacion::class)->findAll();
    }
    public function newReclamacion(){
        $reclamacion = new Reclamacion();
        return $reclamacion;
    }

    public function addReclamacion(Reclamacion  $reclamacion){
        $this->em->persist($reclamacion);
        $this->em->flush();
    }
    public function updateReclamacion(Reclamacion  $reclamacion){
        $this->em->persist($reclamacion);
        $this->em->flush();
    }
}
