<?php


namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * Group
 *
 * @ORM\Table(name="site_donate_durations")
 * @ORM\Entity
 */
class Group
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="user_id")
     * })
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string")
     */
    private $group;

    /**
     * @var Server
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Server")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="server_id", referencedColumnName="id")
     * })
     */
    private $server;

    /**
     * @var \DateTimeImmutable
     *
     * @ORM\Column(name="date_start", type="datetime_immutable")
     */
    private $dateStart;

    /**
     * @var int
     *
     * @ORM\Column(name="date_end", type="integer")
     */
    private $dateEnd;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return Server
     */
    public function getServer(): Server
    {
        return $this->server;
    }

    /**
     * @return string
     */
    public function getGroup(): string
    {
        return $this->group;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getDateStart(): \DateTimeImmutable
    {
        return $this->dateStart;
    }

    /**
     * @return int
     */
    public function getDateEnd(): int
    {
        return $this->dateEnd;
    }

    /**
     * @param int $dateEnd
     */
    public function setDateEnd(int $dateEnd): void
    {
        $this->dateEnd = $dateEnd;
    }

    public function __toArray(): array
    {
        return [
            'id' => $this->id,
            //'user' => $this->user->__toArray(),
            'server' => !is_null($this->server) ? $this->server->__toArray() : null,
            'group' => $this->group,
            'date_start' => $this->dateStart->getTimestamp(),
            'date_end' => (int) $this->dateEnd
        ];
    }
}