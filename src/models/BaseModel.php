<?php
namespace App\Models;

abstract class BaseModel {
    public function toArray(): array {
        return get_object_vars($this);
    }

    public function formArray(array $data): self {
        foreach ($data as $key => $value) {
        $method = 'set' . ucfirst($key);
        if (method_exists($this, $method)) {
            $this->$method($value);
        }
    }
    return $this;
}
}
