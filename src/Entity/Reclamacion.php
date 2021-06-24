<?php

namespace App\Entity;

use App\Repository\ReclamacionRepository;
use Doctrine\ORM\Mapping as ORM;
use PhpOffice\PhpSpreadsheet\Shared\Date;

/**
 * @ORM\Entity(repositoryClass=ReclamacionRepository::class)
 */
class Reclamacion
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_registro", type="datetime")
     */
    private $fecha_registro;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=100)
     */
    private $nombres;

    /**
     * @var string
     *
     * @ORM\Column(name="apellido_paterno", type="string", length=100)
     */
    private $apellido_paterno;

    /**
     * @var string
     *
     * @ORM\Column(name="apellido_materno", type="string", length=100)
     */
    private $apellido_materno;

    /**
     * @ORM\Column(name="tipo_documento", type="string", length=10)
     */
    private $tipo_documento;

    /**
     * @ORM\Column(name="documento", type="string", length=20)
     */
    private $documento;
    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="celular1", type="string", length=20, nullable=true)
     */
    private $celular;
    /**
     * @ORM\Column(name="bien_contratado", type="string", length=20)
     */
    private $bien_contratado;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=150)
     */
    private $descripcion;

    /**
     * @ORM\Column(name="detalle_reclamo", type="string", length=20)
     */
    private $detalle_reclamo;

    /**
     * @var string
     *
     * @ORM\Column(name="detalle", type="string", length=250)
     */
    private $detalle;

    public function __construct()
    {
        $this->fecha_registro = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFechaRegistro(): ?\DateTimeInterface
    {
        return $this->fecha_registro;
    }

    public function setFechaRegistro(\DateTimeInterface $fecha): self
    {
        $this->fecha_registro = $fecha;

        return $this;
    }

    public function getNombres(): ?string
    {
        return $this->nombres;
    }

    public function setNombres(string $nombres): self
    {
        $this->nombres = $nombres;

        return $this;
    }

    public function getApellidoPaterno(): ?string
    {
        return $this->apellido_paterno;
    }

    public function setApellidoPaterno(string $apellido_paterno): self
    {
        $this->apellido_paterno = $apellido_paterno;

        return $this;
    }

    public function getApellidoMaterno(): ?string
    {
        return $this->apellido_materno;
    }

    public function setApellidoMaterno(string $apellido_materno): self
    {
        $this->apellido_materno = $apellido_materno;

        return $this;
    }

    public function getTipoDocumento(): ?string
    {
        return $this->tipo_documento;
    }

    public function setTipoDocumento(string $tipo_documento): self
    {
        $this->tipo_documento = $tipo_documento;

        return $this;
    }

    public function getDocumento(): ?string
    {
        return $this->documento;
    }

    public function setDocumento(string $documento): self
    {
        $this->documento = $documento;

        return $this;
    }

    public function getBienContratado(): ?string
    {
        return $this->bien_contratado;
    }

    public function setBienContratado(string $bien_contratado): self
    {
        $this->bien_contratado = $bien_contratado;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getDetalleReclamo(): ?string
    {
        return $this->detalle_reclamo;
    }

    public function setDetalleReclamo(string $detalle_reclamo): self
    {
        $this->detalle_reclamo = $detalle_reclamo;

        return $this;
    }

    public function getDetalle(): ?string
    {
        return $this->detalle;
    }

    public function setDetalle(string $detalle): self
    {
        $this->detalle = $detalle;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail( $email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getCelular()
    {
        return $this->celular;
    }

    /**
     * @param string $celular
     */
    public function setCelular( $celular)
    {
        $this->celular = $celular;
    }

}
