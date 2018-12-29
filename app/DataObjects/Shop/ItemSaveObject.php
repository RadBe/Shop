<?php


namespace App\DataObjects\Shop;


use App\Entity\Shop\Type;
use Illuminate\Http\UploadedFile;

class ItemSaveObject
{
    /**
     * @var Type
     */
    private $type;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string|null
     */
    private $description;

    /**
     * @var UploadedFile|null
     */
    private $picture;

    /**
     * @var array
     */
    private $extra;

    /**
     * ItemSaveObject constructor.
     *
     * @param Type $type
     * @param string $name
     * @param null|string $description
     * @param UploadedFile|null $picture
     * @param array $extra
     */
    public function __construct(
        Type $type, string $name,
        ?string $description = null,
        ?UploadedFile $picture = null,
        array $extra = [])
    {
        $this->type = $type;
        $this->name = $name;
        $this->description = $description;
        $this->picture = $picture;
        $this->extra = $extra;

        $this->filterExtra();
    }

    private function filterExtra(): void
    {
        $needs = [];
        foreach ($this->type->getExtraArray() as $key => $value)
        {
            $key = explode(':', $key)[0];
            if(is_array($value)) {
                foreach ($value as $key2 => $value2)
                {
                    $key2 = explode(':', $key2)[0];
                    $needs[$key][$key2] = 1;
                }
            } else {
                $needs[$key] = 1;
            }
        }

        foreach ($this->extra as $key => $value)
        {
            if(is_array($value)) {
                foreach ($value as $key2 => $value2)
                {
                    if(!isset($needs[$key])) {
                        unset($this->extra[$key]);
                        break;
                    }

                    if(!isset($needs[$key][$key2])) {
                        unset($this->extra[$key][$key2]);
                    }
                }
            } else {
                if(!isset($needs[$key])) {
                    unset($this->extra[$key]);
                }
            }
        }
    }

    /**
     * @return Type
     */
    public function getType(): Type
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return null|string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return UploadedFile|null
     */
    public function getPicture(): ?UploadedFile
    {
        return $this->picture;
    }

    /**
     * @return array
     */
    public function getExtra(): array
    {
        return $this->extra;
    }
}