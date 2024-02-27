<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use App\Repository\PlatformRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use Symfony\Component\Uid\Uuid;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PlatformRepository::class)]
#[Vich\Uploadable]
#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Post(),
        new Put(),
        new Patch(),
    ],
    normalizationContext: [
        'groups' => ['platform:read'],
    ],
    denormalizationContext: [
        'groups' => ['platform:write'],
    ]

)]
class Platform
{
    #[ORM\Id]
    #[ORM\Column(type: "uuid", unique: true)]
    #[ORM\GeneratedValue(strategy: "CUSTOM")]
    #[ORM\CustomIdGenerator(class: "doctrine.uuid_generator")]
    #[ApiProperty(identifier: true)]
    private Uuid $id;

    #[ORM\Column(length: 100)]
    #[Groups(['platform:read', 'platform:write'])]
    private ?string $name = null;

    #[ORM\Column(length: 100)]
    #[Groups(['platform:read', 'platform:write'])]
    private ?string $slug = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['platform:read', 'platform:write'])]
    private ?string $description = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    #[Groups(['platform:read'])]
    private ?string $logoPath = null;

    #[Vich\UploadableField(mapping: 'platform_logo', fileNameProperty: 'logoPath')]
    #[Groups(['platform:write'])]
    private ?File $logoFile = null;

    #[ORM\ManyToMany(targetEntity: Game::class, inversedBy: 'platforms')]
    private Collection $games;

    public function __construct()
    {
        $this->games = new ArrayCollection();
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getLogoPath(?string $logoPath): ?string
    {
        return $this->logoPath;
    }

    public function setLogoPath(?string $logoPath): static
    {
        $this->logoPath = $logoPath;

        return $this;
    }

    public function getLogoFile(): ?File
    {
        // TODO: Implement getLogoFile() method.
        return $this->logoFile;
    }

    public function setLogoFile(?File $image): void
    {
        $this->logoFile = $image;

        if ($image) {
            // TODO: set logoPath with name of file
        }
    }

    /**
     * @return Collection<int, Game>
     */
    public function getGames(): Collection
    {
        return $this->games;
    }

    public function addGame(Game $game): static
    {
        if (!$this->games->contains($game)) {
            $this->games->add($game);
            $game->addPlatform($this);
        }

        return $this;
    }

    public function removeGame(Game $game): static
    {
        if ($this->games->removeElement($game)) {
            $game->removePlatform($this);
        }

        return $this;
    }
}
