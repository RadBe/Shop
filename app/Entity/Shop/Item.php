<?php


namespace App\Entity\Shop;

use Doctrine\ORM\Mapping as ORM;

/**
 * Shop\Item
 *
 * @ORM\Table(name="site_shop_items")
 * @ORM\Entity
 */
class Item
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
     * @var Type
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Shop\Type")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="type", referencedColumnName="id")
     * })
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string")
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="string", nullable=true)
     */
    private $description;

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
     * Item constructor.
     *
     * @param Type $type
     * @param string $name
     * @param null|string $description
     * @param array $extra
     */
    public function __construct(Type $type, string $name, ?string $description, array $extra = [])
    {
        $this->type = $type;
        $this->name = $name;
        $this->description = $description;
        $this->extra = json_encode($extra);
        $this->extraArray = $extra;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Type
     */
    public function getType(): Type
    {
        return $this->type;
    }

    /**
     * @param Type $type
     * @return Item
     */
    public function setType(Type $type): Item
    {
        $this->type = $type;

        return $this;
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
     * @return Item
     */
    public function setName(string $name): Item
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param null|string $description
     * @return Item
     */
    public function setDescription(?string $description): Item
    {
        $this->description = $description;

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
     * @return Item
     */
    public function setExtra(array $extra = []): Item
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
            $this->extraArray = (array) json_decode($this->extra, true);
        }

        return $this->extraArray;
    }

    public function __toArray(): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type->__toArray(),
            'name' => $this->name,
            'description' => $this->description,
            'extra' => $this->getExtraArray()
        ];
    }
}