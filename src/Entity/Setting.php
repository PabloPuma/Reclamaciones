<?php

namespace App\Entity;

use App\Repository\SettingRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SettingRepository::class)
 */
class Setting
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombreProyecto", type="string", length=255)
     */
    private $nombre_proyecto;

    /**
     * @var string
     *
     * @ORM\Column(name="paginaWeb", type="string", length=255)
     */
    private $pagina_web;

    /**
     * @var string
     *
     * @ORM\Column(name="favicon", type="string", length=255)
     */
    private $favicon;

    /**
     * @var string
     *
     * @ORM\Column(name="logo", type="string", length=255)
     */
    private $logo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombreProyecto(): ?string
    {
        return $this->nombre_proyecto;
    }

    public function setNombreProyecto(string $nombre_proyecto): self
    {
        $this->nombre_proyecto = $nombre_proyecto;

        return $this;
    }

    public function getPaginaWeb(): ?string
    {
        return $this->pagina_web;
    }

    public function setPaginaWeb(string $pagina_web): self
    {
        $this->pagina_web = $pagina_web;

        return $this;
    }

    public function getFavicon(): ?string
    {
        return $this->favicon;
    }

    public function setFavicon(string $favicon): self
    {
        $this->favicon = $favicon;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }
}
