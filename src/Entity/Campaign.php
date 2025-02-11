<?php

namespace App\Entity;

use App\Repository\CampaignRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CampaignRepository::class)]
class Campaign
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column]
    private ?int $goal = null;


    #[ORM\OneToMany(mappedBy: 'campaign', targetEntity: Participant::class, orphanRemoval: true)]
    private Collection $participants;

    #[ORM\Column(length: 255)]
    private ?string $creatorName = null;

    #[ORM\Column(length: 255)]
    private ?string $creatorEmail = null;

    public function __construct()
    {
        $this->participants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getGoal(): ?int
    {
        return $this->goal;
    }

    public function setGoal(int $goal): static
    {
        $this->goal = $goal;

        return $this;
    }

    /**
     * @return Collection<int, Participant>
     */
    public function getParticipants(): Collection
    {
        return $this->participants;
    }

    public function addParticipant(Participant $participant): static
    {
        if (!$this->participants->contains($participant)) {
            $this->participants->add($participant);
            $participant->setCampaign($this);
        }

        return $this;
    }

    public function removeParticipant(Participant $participant): static
    {
        if ($this->participants->removeElement($participant)) {
            // set the owning side to null (unless already changed)
            if ($participant->getCampaign() === $this) {
                $participant->setCampaign(null);
            }
        }

        return $this;
    }

    public function getCreatorName(): ?string
    {
        return $this->creatorName;
    }

    public function setCreatorName(string $creatorName): static
    {
        $this->creatorName = $creatorName;

        return $this;
    }

    public function getCreatorEmail(): ?string
    {
        return $this->creatorEmail;
    }

    public function setCreatorEmail(string $creatorEmail): static
    {
        $this->creatorEmail = $creatorEmail;

        return $this;
    }

    public function getTotaleAmount(): int {
        $payments = [];
        foreach ($this->getParticipants() as $participant) {
            array_push($payments, ...$participant->getPayments());
        }

        $addis = array_sum(array_map(function($payment) {
            return $payment->getAmount();
        }, $payments));

        return $addis;
    }

    public function progressBar(): int
    {
        $goal = $this->getGoal();
        $sum = $this->getTotaleAmount();
        if( $goal === 0){
            return 0;
        }elseif($sum === $goal){
            return 100;
        }
        return round(($sum/$goal)*100);
    }


}
