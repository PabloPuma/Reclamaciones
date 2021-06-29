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
    const PASAPORTE         =  7;
    const DNI               =   1;
    const RUC               =   6;
    const CE            =   0;
    const OTROS =-1;

    const PENDIENTE = 0;
    const OK = 1;
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
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="celular1", type="string", length=20, nullable=false)
     */
    private $celular;
    /**
     * @ORM\Column(name="bien_contratado", type="string", length=20)
     */
    private $bien_contratado;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text")
     */
    private $descripcion;

    /**
     * @ORM\Column(name="detalle_reclamo", type="string", length=20)
     */
    private $detalle_reclamo;

    /**
     * @var string
     *
     * @ORM\Column(name="detalle", type="text")
     */
    private $detalle;

    /**
     * @var string
     *
     * @ORM\Column(name="hash", type="string", length=255)
     */
    private $hash;
    /**
     * @var bool
     *
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado;

    /**
     * @var Usuario
     *
     * @ORM\ManyToOne(targetEntity="Usuario", fetch="EAGER" )
     * @ORM\JoinColumn(name="supervisor_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $supervisor;
    /**
     * @var string
     *
     * @ORM\Column(name="respuesta", type="text",nullable=true)
     */
    private $respuesta;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_respuesta", type="datetime",nullable=true)
     */
    private $fecha_respuesta;

    public function __construct()
    {
        $this->fecha_registro = new \DateTime();
        $this->estado = Reclamacion::PENDIENTE;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombreCompletoApellidosPrimero()
    {
        return $this->getApellidoPaterno() . " " . $this->getApellidoMaterno() . ", " . $this->getNombres();
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

    /**
     * @return string
     */
    public function getHash(): string
    {
        return $this->hash;
    }

    /**
     * @param string $hash
     */
    public function setHash(string $hash): void
    {
        $this->hash = $hash;
    }

    /**
     * @return bool
     */
    public function isEstado()
    {
        return $this->estado;
    }

    /**
     * @param bool $estado
     */
    public function setEstado($estado): void
    {
        $this->estado = $estado;
    }

    /**
     * @return Usuario
     */
    public function getSupervisor(): Usuario
    {
        return $this->supervisor;
    }

    /**
     * @param Usuario $supervisor
     */
    public function setSupervisor(Usuario $supervisor): void
    {
        $this->supervisor = $supervisor;
    }

    /**
     * @return string
     */
    public function getRespuesta(): string
    {
        return $this->respuesta;
    }

    /**
     * @param string $respuesta
     */
    public function setRespuesta(string $respuesta): void
    {
        $this->respuesta = $respuesta;
    }

    /**
     * @return \DateTime
     */
    public function getFechaRespuesta(): \DateTime
    {
        return $this->fecha_respuesta;
    }

    /**
     * @param \DateTime $fecha_respuesta
     */
    public function setFechaRespuesta(\DateTime $fecha_respuesta): void
    {
        $this->fecha_respuesta = $fecha_respuesta;
    }


}
