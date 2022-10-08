<?php

function isFormFilled(array $formInputs, array $exceptions): bool {
    foreach ($formInputs as $name => $value) {
        if (!in_array($name, $exceptions) && $value == '') {
            return false;
        }
    }
    return true;
}

function formMatchesTable(array $form, array $tableColumns): bool {
    foreach ($form as $key => $value) {
        if (!in_array($key, $tableColumns)) {
            return false;
        }
    }
    return true;
}

function findModelValidationsError(array $fieldsRequirements) { // Multiple form errors
    foreach ($fieldsRequirements as $fieldName => $requirements) {
        foreach ($requirements as $requirement) {
            $isValidFn = $requirement['validateFn'];
            if (!$isValidFn()) {
                $errorFn = $requirement['getErrorFn'];
                return $errorFn($fieldName);
            };
        }
    }
    return false;
}

// Input requirements

function minLength(string|null $value, int $minAmount): array {
    return array(
        "validateFn" => function() use($value, $minAmount): bool {
            if ($value == null) return true;
            return (strlen($value) < $minAmount) ? false : true;
        },
        "getErrorFn" => function(string $field) use($minAmount): string {
            return "Le champs \"$field\" doit contenir au moins $minAmount caractères.";
        }
    );
}

function maxLength(string|null $value, int $maxAmount): array {
    return array(
        "validateFn" => function() use($value, $maxAmount): bool {
            if ($value == null) return true;
            return (strlen($value) > $maxAmount) ? false : true;
        },
        "getErrorFn" => function(string $field) use($maxAmount): string {
            return "Le champs \"$field\" ne peut contenir que $maxAmount caractères maximum.";
        }
    );
}

function betweenLengths(string|null $value, int $minAmount, int $maxAmount): array {
    return array(
        "validateFn" => function() use($value, $minAmount, $maxAmount): bool {
            if ($value == null) return true;
            return (strlen($value) < $minAmount || strlen($value) > $maxAmount) ? false : true;
        },
        "getErrorFn" => function(string $field) use($minAmount, $maxAmount): string {
            return "Le champs \"$field\" doit contenir entre $minAmount et $maxAmount caractères.";
        }
    );
}

function betweenNumbers(int|null $number, int $minNumber, int $maxNumber): array {
    return array(
        "validateFn" => function() use($number, $minNumber, $maxNumber): bool {
            if ($number == null) return true;
            return ($number < $minNumber || $number > $maxNumber) ? false : true;
        },
        "getErrorFn" => function(string $field) use($minNumber, $maxNumber): string {
            return "Le champs \"$field\" doit être compris entre $minNumber et $maxNumber.";
        }
    );
}

function amongValues(mixed $value, array $values): array {
    return array(
        "validateFn" => function() use($value, $values): bool {
            if ($value == null) return true;
            return (in_array($value, $values)) ? true : false;
        },
        "getErrorFn" => function(string $field) use($values): string {
            $errorValues = implode(', ', $values);
            return "Le champ \"$field\" doit contenir une des valeurs suivantes : $errorValues.";
        }
    );
}

function validEmail(string|null $email): array {
    return array(
        "validateFn" => function() use($email): bool {
            if ($email == null) return true;
            return filter_var($email, FILTER_VALIDATE_EMAIL) ? true : false;
        },
        "getErrorFn" => function(string $field): string {
            return "L'email n'est pas valide.";
        }
    );
}

function validLength(string|null $value, int $length): array {
    return array(
        "validateFn" => function() use($value, $length): bool {
            if ($value == null) return true;
            return (strlen($value) == $length) ? true : false;
        },
        "getErrorFn" => function(string $field) use($length): string {
            return "Le champ \"$field\" doit contenir $length caractères.";
        }
    );
}