<?php


namespace App\Services\Shop;


use App\Exceptions\RuntimeException;

class ItemExtraValidator
{
    public function validate(array $itemExtra, array $requestExtra): void
    {
        $this->foreach(
            $itemExtra,
            $requestExtra
        );
    }

    private function foreach(array $extra, array $params)
    {
        foreach ($extra as $key => $value)
        {
            if(!is_array($value)) {
                $this->validateString($key, $value, $params);
            } else {
                $this->validateArray($key, $value, $params);
            }
        }
    }

    private function validateString(string $key, $value, array $params)
    {
        $keyExpl = explode(':', $key);

        $key = $keyExpl[0];

        $count = count($keyExpl);

        $required = $count > 1 && in_array('required', $keyExpl);

        if(!isset($params[$key]) || ($required && trim($params[$key]) == '')) {
            throw new RuntimeException("Вы не заполнили поле '$value'!");
        }
    }

    private function validateArray(string $key, $value, $params)
    {
        $keyExpl = explode(':', $key);

        $key = $keyExpl[0];

        $count = count($keyExpl);

        $required = $count > 1 && in_array('required', $keyExpl);

        if(!isset($params[$key]) || ($required && !is_array($params[$key]))) {
            throw new RuntimeException("Значение поля '$key' должно быть массивом!");
        } elseif (!$required && (!is_array($params[$key]) || empty($params[$key]))) {
            return;
        }

        $this->foreach($value, $params[$key]);
    }
}