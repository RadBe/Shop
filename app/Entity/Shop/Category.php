<?php


namespace App\Entity\Shop;


use App\Entity\Server;
use Doctrine\ORM\Mapping as ORM;

/**
 * Shop\Category
 *
 * @ORM\Table(name="site_shop_categories")
 * @ORM\Entity
 */
class Category
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
     * @var Server|null
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
     * @ORM\Column(name="name", type="string")
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="weight", type="integer")
     */
    private $weight;

    /**
     * Category constructor.
     *
     * @param Server|null $server
     * @param string $name
     * @param int $weight
     */
    public function __construct(?Server $server, string $name, int $weight)
    {
        $this->server = $server;
        $this->name = $name;
        $this->weight = $weight;
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
     * @return Category
     */
    public function setName(string $name): Category
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Server|null
     */
    public function getServer(): ?Server
    {
        return $this->server;
    }

    /**
     * @param Server|null $server
     * @return Category
     */
    public function setServer(?Server $server): Category
    {
        $this->server = $server;

        return $this;
    }

    /**
     * @return int
     */
    public function getWeight(): int
    {
        return $this->weight;
    }

    /**
     * @param int $weight
     * @return Category
     */
    public function setWeight(int $weight): Category
    {
        $this->weight = $weight;

        return $this;
    }

    public function __toArray(): array
    {
        return [
            'id' => $this->id,
            'server' => $this->server->__toArray(),
            'name' => $this->name,
            'weight' => $this->weight
        ];
    }
}