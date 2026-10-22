<?php
namespace App\Providers;

class Validator{
    private $errors = array();
    private string $key;
    private string $value;
    private string $name;

    public function field(string $key, string $value, $name = null)
    {
        $this->key = $key;
        $this->value = $value;
        if ($name == null) {
            $this->name = ucfirst($key);
        } else {
            $this->name = ucfirst($name);
        }
        return $this;
    }

    public function required()
    {
        if (empty($this->value)) {
            $this->errors[$this->key] = "$this->name est requis!";
        }
        return $this;
    }

    public function min(int $length)
    {
        if (strlen($this->value) < $length) {
            $this->errors[$this->key] = "$this->name doit être plus que $length caractères!";
        }
        return $this;
    }

    public function max($length)
    {
        if (strlen($this->value) > $length) {
            $this->errors[$this->key] = "$this->name doit être moins que $length caractères!";
        }
        return $this;
    }


    public function date()
    {
        if (!empty($this->value)) {
            $date = \DateTime::createFromFormat('!Y-m-d', $this->value);

            if ($date == false || $date->format('Y-m-d') != $this->value) {
                $this->errors[$this->key] = "La date doit être valide et respecter le format AAAA-MM-JJ.";
            }
        }

        return $this;
    }


    public function isSuccess()
    {
        return empty($this->errors);
    }

    public function getErrors()
    {
        if (!$this->isSuccess()) return $this->errors;
    }
}