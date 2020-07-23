<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SectionRepository")
 */
class Section
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $icon;

    /**
     * @ORM\Column(type="boolean")
     */
    private $deleted;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Section", inversedBy="subsections")
     */
    private $linkedSection;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Section", mappedBy="linkedSection")
     */
    private $subsections;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Community", inversedBy="sections")
     * @ORM\JoinColumn(nullable=false)
     */
    private $community;

    /**
     * @ORM\Column(type="integer")
     */
    private $sort;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Topic", mappedBy="section")
     * @ORM\OrderBy({"createdAt" = "DESC", "updatedAt" = "DESC"})
     */
    private $topics;

    public function __construct()
    {
        $this->subsections = new ArrayCollection();
        $this->topics = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    public function getDeleted(): ?bool
    {
        return $this->deleted;
    }

    public function setDeleted(bool $deleted): self
    {
        $this->deleted = $deleted;

        return $this;
    }

    public function getLinkedSection(): ?self
    {
        return $this->linkedSection;
    }

    public function setLinkedSection(?self $linkedSection): self
    {
        $this->linkedSection = $linkedSection;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getSubsections(): Collection
    {
        return $this->subsections;
    }

    public function addSubsection(self $subsection): self
    {
        if (!$this->subsections->contains($subsection)) {
            $this->subsections[] = $subsection;
            $subsection->setLinkedSection($this);
        }

        return $this;
    }

    public function removeSubsection(self $subsection): self
    {
        if ($this->subsections->contains($subsection)) {
            $this->subsections->removeElement($subsection);
            // set the owning side to null (unless already changed)
            if ($subsection->getLinkedSection() === $this) {
                $subsection->setLinkedSection(null);
            }
        }

        return $this;
    }

    public function getCommunity(): ?Community
    {
        return $this->community;
    }

    public function setCommunity(?Community $community): self
    {
        $this->community = $community;

        return $this;
    }

    public function getSort(): ?int
    {
        return $this->sort;
    }

    public function setSort(int $sort): self
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * @return Collection|Topic[]
     */
    public function getTopics(): Collection
    {
        return $this->topics;
    }

    public function addTopic(Topic $topic): self
    {
        if (!$this->topics->contains($topic)) {
            $this->topics[] = $topic;
            $topic->setSection($this);
        }

        return $this;
    }

    public function removeTopic(Topic $topic): self
    {
        if ($this->topics->contains($topic)) {
            $this->topics->removeElement($topic);
            // set the owning side to null (unless already changed)
            if ($topic->getSection() === $this) {
                $topic->setSection(null);
            }
        }

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }
}
