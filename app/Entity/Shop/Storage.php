<?php


namespace App\Entity\Shop;


use App\Entity\Server;
use Doctrine\ORM\Mapping as ORM;

/**
 * Shop\Storage
 *
 * @ORM\Table(name="site_shop_storage")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Storage
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
     * @var Server
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Server")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="server_id", referencedColumnName="id")
     * })
     */
    private $server;

    /**
     * @var string
     *
     * @ORM\Column(name="uuid", type="string")
     */
    private $uuid;

    /**
     * @var string
     *
     * @ORM\Column(name="item", type="string")
     */
    private $item;

    /**
     * @var int
     *
     * @ORM\Column(name="amount", type="integer")
     */
    private $amount;

    /**
     * @var \DateTimeImmutable
     *
     * @ORM\Column(name="date", type="datetime_immutable")
     */
    private $date;

    /**
     * Storage constructor.
     *
     * @param Server $server
     * @param string $uuid
     * @param string $item
     * @param int $amount
     * @throws \Exception
     */
    public function __construct(Server $server, string $uuid, string $item, int $amount)
    {
        $this->server = $server;
        $this->uuid = $uuid;
        $this->item = $item;
        $this->amount = $amount;
        $this->date = new \DateTimeImmutable();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
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
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @return string
     */
    public function getItem(): string
    {
        return $this->item;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }
}