<?php

namespace App\Entity;

use App\Repository\AjoutEvenementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AjoutEvenementRepository::class)]
class AjoutEvenement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $titre = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\Column(length: 100)]
    private ?string $ville = null;

    #[ORM\Column(length: 15)]
    private ?string $date = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'ajoutEvenements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $userId = null;

    #[ORM\OneToMany(mappedBy: 'ajoutEvenement', targetEntity: Reservation::class)]
    private Collection $reservations;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(string $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->userId;
    }

    public function setUserId(?User $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): static
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setAjoutEvenement($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): static
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getAjoutEvenement() === $this) {
                $reservation->setAjoutEvenement(null);
            }
        }

        return $this;
    }
} 


/*
namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\AjoutEvenement;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Création d'un utilisateur admin
        $adminUser = new User();
        $adminUser->setEmail('admin@gmail.com');
        $adminUser->setPassword(password_hash('123456', PASSWORD_DEFAULT));
        $adminUser->setNom('Boss');
        $adminUser->setPrenom('Patron');
        $adminUser->setAdresse('25 rue de janeiro');
        $adminUser->setVille('Rio');
        $adminUser->setCodepostal('99');
        $adminUser->setTelephone('0712345678');
        $adminUser->setCreatedAt(new \DateTime('now'));
        $adminUser->setRoles(['ROLE_ADMIN']);
        $manager->persist($adminUser);

        // Ajout de quelques événements fictifs
        $events = [
            [
                'titre' => 'Concert Live à Paris',
                'image' => 'concert.jpg',
                'description' => 'Un concert incroyable au cœur de Paris.',
                'prix' => 25.00,
                'ville' => 'Paris',
                'date' => '2025-05-15',
            ],
            [
                'titre' => 'Festival de musique urbaine',
                'image' => 'festival.jpg',
                'description' => 'Un festival rassemblant les meilleurs artistes urbains.',
                'prix' => 40.00,
                'ville' => 'Marseille',
                'date' => '2025-06-20',
            ],
        ];

        foreach ($events as $data) {
            $event = new AjoutEvenement();
            $event->setTitre($data['titre']);
            $event->setImage($data['image']);
            $event->setDescription($data['description']);
            $event->setPrix($data['prix']);
            $event->setVille($data['ville']);
            $event->setDate($data['date']);
            $event->setCreatedAt(new \DateTime());
            $event->setUserId($adminUser); // lien vers l'utilisateur
            $manager->persist($event);
        }

        $manager->flush();
    }
}
 
*/
