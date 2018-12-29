<?php


namespace App\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="dle_users")
 * @ORM\Entity
 */
class User
{
    /**
     * @var int
     *
     * @ORM\Column(name="user_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="uuid", type="string")
     */
    private $uuid;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string")
     */
    private $email;

    /**
     * @var int
     *
     * @ORM\Column(name="user_group", type="integer")
     */
    private $siteGroup;

    /**
     * @var int
     *
     * @ORM\Column(name="reg_date", type="integer")
     */
    private $regDate;

    /**
     * @var int
     *
     * @ORM\Column(name="lastdate", type="integer")
     */
    private $entryDate;

    /**
     * @var int
     *
     * @ORM\Column(name="cash", type="integer")
     */
    private $money = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="vote_cases", type="integer")
     */
    private $cases = 0;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Group", mappedBy="user", cascade={"persist"})
     */
    private $groups;

    public function __construct()
    {
        $this->groups = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return int
     */
    public function getRegDate(): int
    {
        return $this->regDate;
    }

    /**
     * @return int
     */
    public function getEntryDate(): int
    {
        return $this->entryDate;
    }

    /**
     * @return int
     */
    public function getMoney(): int
    {
        return $this->money;
    }

    /**
     * @return int
     */
    public function getCases(): int
    {
        return $this->cases;
    }

    /**
     * @return int
     */
    public function getSiteGroup(): int
    {
        return $this->siteGroup;
    }

    /**
     * @return Collection
     */
    public function getGroups(): Collection
    {
        return $this->groups;
    }

    public function hasMoney(int $need): bool
    {
        return $this->money >= $need;
    }

    public function withdrawMoney(int $amount): void
    {
        $this->money -= $amount;
    }

    public function __toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'uuid' => $this->uuid,
            'email' => $this->email,
            'site_group' => $this->siteGroup,
            'reg_date' => $this->regDate,
            'entry_date' => $this->entryDate,
            'money' => $this->money,
            'cases' => $this->cases,
            'groups' => array_map(function (Group $group) {
                return $group->__toArray();
            }, $this->groups->toArray())
        ];
    }
}