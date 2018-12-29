<?php


namespace App\Services\Settings;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="site_settings")
 * @ORM\HasLifecycleCallbacks
 */
class Setting
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="`key`", type="string", length=100, unique=true, nullable=false)
     */
    private $key;

    /**
     * @var string|null
     *
     * @ORM\Column(name="value", type="text", unique=false, nullable=true)
     */
    private $value;

    /**
     * @var \DateTimeImmutable|null
     *
     * @ORM\Column(name="updatedAt", type="datetime_immutable", nullable=true)
     */
    private $updatedAt;

    /**
     * Setting constructor.
     *
     * @param string $key
     * @param mixed $value
     */
    public function __construct(string $key, $value)
    {
        $this->key = $key;
        $this->value = $value;
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
    public function getKey(): string
    {
        return $this->key;
    }

    public function setValue($value): void
    {
        $this->value = $value;
    }

    /**
     * @param null|string $castTo
     *
     * @return mixed
     */
    public function getValue(?string $castTo = null): ?string
    {
        switch ($castTo) {
            case DataType::BOOL:
                return (bool)$this->value;
            case DataType::INT:
                return (int)$this->value;
            case DataType::FLOAT:
                return (float)$this->value;
            case DataType::JSON:
                return json_decode($this->value);
            case DataType::SERIALIZED:
                return unserialize($this->value);
            default:
                return $this->value;
        }
    }

    /**
     * @ORM\PreUpdate
     */
    public function generateUpdatedAt(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}