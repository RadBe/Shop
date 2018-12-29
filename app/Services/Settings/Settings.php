<?php


namespace App\Services\Settings;


use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

class Settings
{
    private $driver;

    private $store;

    public function __construct(Driver $driver)
    {
        $this->driver = $driver;
        $this->store = new Store($driver->load());
    }

    public function get(string $key, $default = null)
    {
        return $this->exists($key) ? $this->store->get($key) : $default;
    }

    public function set(string $key, $value): void
    {
        if ($value instanceof \JsonSerializable) {
            $value = json_encode($value);
        }
        if ($value instanceof Jsonable) {
            $value = $value->toJson();
        }
        if ($value instanceof Arrayable) {
            $value = $value->toArray();
        }
        if ($value instanceof \Serializable || is_object($value)) {
            $value = serialize($value);
        }
        if (is_array($value)) {
            $value = json_encode($value);
        }
        if (is_bool($value)) {
            $value = (int)$value;
        }

        $setting = $this->store->set($key, $value);

        if($this->store->lastAction() == 'create') {
            $this->driver->repository()->create($setting);
        } else {
            $this->driver->repository()->update($setting);
        }
    }

    public function remove(string $key): void
    {
        $setting = $this->store->remove($key);
        if(!is_null($setting)) {
            $this->driver->repository()->delete($setting);
        }
    }

    public function setArray(array $data): void
    {
        $data = array_dot($data);
        foreach ($data as $key => $value)
        {
            $this->set($key, $value);
        }
    }

    public function exists(string $key): bool
    {
        return $this->store->exists($key);
    }
}