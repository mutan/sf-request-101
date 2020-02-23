<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WarehouseRepository")
 * @ORM\Table(options={"comment": "Склады"})
 */
class Warehouse
{
    /**
     * @var int
     *
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", unique=true, length=255, options={"comment": "Код склада"})
     */
    private $code;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, options={"comment": "Название склада"})
     */
    private $name;

    /**
     * @var boolean
     * @ORM\Column(type="boolean", options={"default" : true})
     */
    private $active;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }
}
