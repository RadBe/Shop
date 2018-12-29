<?php


namespace App\Entity\Shop;


use Doctrine\ORM\Mapping as ORM;

/**
 * Shop\Type
 *
 * @ORM\Table(name="site_shop_types")
 * @ORM\Entity
 */
class Type
{
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
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
     * @ORM\Column(name="distributor", type="string")
     */
    private $distributor;

    /**
     * @var string
     *
     * @ORM\Column(name="extra", type="text")
     */
    private $extra;

    /**
     * @var array
     */
    private $extraArray;

    /**
     * Type constructor.
     *
     * @param string $id
     * @param string $name
     * @param string $distributor
     * @param array $extra
     */
    public function __construct(string $id, string $name, string $distributor, array $extra = [])
    {
        $this->id = $id;
        $this->name = $name;
        $this->distributor = $distributor;
        $this->extra = json_encode($extra);
        $this->extraArray = $extra;
    }

    /**
     * @return string
     */
    public function getId(): string
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
     * @return Type
     */
    public function setName(string $name): Type
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getDistributor(): string
    {
        return $this->distributor;
    }

    /**
     * @param string $distributor
     * @return Type
     */
    public function setDistributor(string $distributor): Type
    {
        $this->distributor = $distributor;

        return $this;
    }

    /**
     * @return string
     */
    public function getExtra(): string
    {
        return $this->extra;
    }

    /**
     * @param array $extra
     * @return Type
     */
    public function setExtra(array $extra = []): Type
    {
        $this->extra = json_encode($extra);
        $this->extraArray = $extra;

        return $this;
    }

    /**
     * @return array
     */
    public function getExtraArray(): array
    {
        if(is_null($this->extraArray)) {
            $this->extraArray = json_decode($this->extra, true);
        }

        return $this->extraArray;
    }

    public function __toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'distributor' => $this->distributor,
            'extra' => $this->getExtraArray()
        ];
    }
}