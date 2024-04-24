<?php

namespace App\Libraries;

use CodeIgniter\Validation\Validation;
use CodeIgniter\Validation\Exceptions\ValidationException;

class MYValidation extends Validation
{
    public function __construct()
    {
        parent::__construct();
    }

    // Custom validation rule: lessThanOtherField
    public function lessThanOtherField(string $value, string $field, array $data): bool
    {
        if (isset($data[$field]) && is_numeric($data[$field])) {
            return ($value < $data[$field]);
        }

        return false;
    }
}