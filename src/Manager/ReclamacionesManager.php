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
    private $tokenStorage;



    public function __construct(EntityManagerInterface $em,TokenStorageInterface  $tokenStorage)
    {
        $this->em = $em;
        $this->tokenStorage = $tokenStorage;

    }

    public function findAll(){
        return $this->em->getRepository(Reclamacion::class)->findAll();
    }
    public function newReclamacion(){
        $reclamacion = new Reclamacion();
        return $reclamacion;
    }


    public function addReclamacion(Reclamacion  $reclamacion){
        $reclamacion->setHash(md5($reclamacion->getDocumento()));
        $this->em->persist($reclamacion);
        $this->em->flush();
    }
    public function updateReclamacion(Reclamacion  $reclamacion){
        $this->em->persist($reclamacion);
        $this->em->flush();
    }
    public function addRepuesta(Reclamacion  $reclamacion){
        $reclamacion->setFechaRespuesta(new \DateTime());
        /** @var Usuario $usuario */
        $usuario = $this->tokenStorage->getToken()->getUser();
        $reclamacion->setSupervisor($usuario);
        $reclamacion->setEstado(true);
        $this->em->persist($reclamacion);
        $this->em->flush();
    }
    public function searchByIdHash($id,$hash){
        /** @var Reclamacion $reclamo */
        $reclamo = $this->em->getRepository(Reclamacion::class)->find($id);
        if(md5($reclamo->getDocumento())!=$hash){
            throw new SchoolException("TOKEN INCORRECTO");
        }
        return $reclamo;
    }
}
