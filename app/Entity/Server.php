<?php


namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * Server
 *
 * @ORM\Table(name="site_servers")
 * @ORM\Entity
 */
class Server
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
     * @var string
     *
     * @ORM\Column(name="name", type="string")
     */
    private $name;

    /**
     * @var bool
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled = false;

    /**
     * @var int
     *
     * @ORM\Column(name="shop_id", type="integer")
     */
    private $shopId;

    /**
     * @var string
     *
     * @ORM\Column(name="ip", type="string")
     */
    private $ip;

    /**
     * @var int
     *
     * @ORM\Column(name="query_port", type="integer")
     */
    private $queryPort;

    /**
     * @var int
     *
     * @ORM\Column(name="rcon_port", type="integer")
     */
    private $rconPort;

    /**
     * @var string
     *
     * @ORM\Column(name="rcon_pass", type="string")
     */
    private $rconPassword;

    /**
     * @var \DateTimeImmutable
     *
     * @ORM\Column(name="created_at", type="datetime_immutable")
     */
    private $createdAt;

    /**
     * Server constructor.
     *
     * @param string $name
     * @param int $shopId
     * @param string $ip
     * @param int $queryPort
     * @param int $rconPort
     * @param string $rconPassword
     */
    public function __construct(string $name, int $shopId, string $ip, int $queryPort, int $rconPort, string $rconPassword)
    {
        $this->name = $name;
        $this->shopId = $shopId;
        $this->ip = $ip;
        $this->queryPort = $queryPort;
        $this->rconPort = $rconPort;
        $this->rconPassword = $rconPassword;
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
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     */
    public function setEnabled(bool $enabled): void
    {
        $this->enabled = $enabled;
    }

    /**
     * @return int
     */
    public function getShopId(): int
    {
        return $this->shopId;
    }

    /**
     * @param int $shopId
     */
    public function setShopId(int $shopId): void
    {
        $this->shopId = $shopId;
    }

    /**
     * @return string
     */
    public function getIp(): string
    {
        return $this->ip;
    }

    /**
     * @param string $ip
     */
    public function setIp(string $ip): void
    {
        $this->ip = $ip;
    }

    /**
     * @return int
     */
    public function getQueryPort(): int
    {
        return $this->queryPort;
    }

    /**
     * @param int $queryPort
     */
    public function setQueryPort(int $queryPort): void
    {
        $this->queryPort = $queryPort;
    }

    /**
     * @return int
     */
    public function getRconPort(): int
    {
        return $this->rconPort;
    }

    /**
     * @param int $rconPort
     */
    public function setRconPort(int $rconPort): void
    {
        $this->rconPort = $rconPort;
    }

    /**
     * @return string
     */
    public function getRconPassword(): string
    {
        return $this->rconPassword;
    }

    /**
     * @param string $rconPassword
     */
    public function setRconPassword(string $rconPassword): void
    {
        $this->rconPassword = $rconPassword;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function __toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'enabled' => (bool) $this->enabled,
            'shop_id' => $this->shopId,
            'port' => $this->queryPort,
            'rcon_port' => $this->rconPort,
            'rcon_password' => $this->rconPassword,
            'created' => $this->createdAt->format('Y-m-d H:i')
        ];
    }
}