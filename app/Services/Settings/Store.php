<?php


namespace App\Services\Settings;


class Store
{
    private $data;

    private $lastAction;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function get(string $key): ?Setting
    {
        foreach ($this->data as $datum)
        {
            if($key === $datum->getKey()) {
                return $datum;
            }
        }

        return null;
    }

    public function set(string $key, $value): Setting
    {
        foreach ($this->data as $datum)
        {
            if($key === $datum->getKey()) {
                $datum->setValue($value);
                $this->lastAction = 'update';
                return $datum;
            }
        }

        $this->lastAction = 'create';
        return $this->data[] = new Setting($key, $value);
    }

    public function remove(string $key): Setting
    {
        foreach ($this->data as $i => $datum)
        {
            if($key === $datum->getKey()) {
                unset($this->data[$i]);
                return $datum;
            }
        }

        return null;
    }

    public function exists(string $key): bool
    {
        foreach ($this->data as $datum)
        {
            if($key === $datum->getKey()) {
                return true;
            }
        }

        return false;
    }

    public function all(): array
    {
        return $this->data;
    }

    public function lastAction(): string
    {
        $action = $this->lastAction;

        $this->lastAction = null;

        return $action;
    }
}