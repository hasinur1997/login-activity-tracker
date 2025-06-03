<?php
namespace Hasinur\LoginActivityTracker\Validation;

/**
 * Class Validator
 * A lightweight Laravel-style validator for WordPress plugin use.
 */
class Validator {
    /**
     * The input data to be validated.
     *
     * @var array
     */
    protected array $data;

    /**
     * The validation rules.
     *
     * @var array
     */
    protected array $rules;

    /**
     * The validation error messages.
     *
     * @var array
     */
    protected array $errors = [];

    /**
     * Validator constructor.
     *
     * @param array $data  The data to validate.
     * @param array $rules The validation rules.
     */
    public function __construct(array $data, array $rules) {
        $this->data  = $data;
        $this->rules = $rules;

        $this->validate();
    }

    /**
     * Run the validation rules against the data.
     *
     * @return void
     */
    protected function validate(): void {
        foreach ($this->rules as $field => $rules) {
            $value = $this->data[$field] ?? null;
            $rules = is_array($rules) ? $rules : explode('|', $rules);

            foreach ($rules as $rule) {
                $parsed = explode(':', $rule);
                $method = 'validate' . ucfirst($parsed[0]);
                $param  = $parsed[1] ?? null;

                if (method_exists($this, $method)) {
                    $this->$method($field, $value, $param);
                }
            }
        }
    }

    /**
     * Check if the validation failed.
     *
     * @return bool
     */
    public function fails(): bool {
        return !empty($this->errors);
    }

    /**
     * Get the array of error messages.
     *
     * @return array
     */
    public function errors(): array {
        return $this->errors;
    }

    /**
     * Alias for errors().
     *
     * @return array
     */
    public function messages(): array {
        return $this->errors();
    }

    /**
     * Validate if the field is required.
     *
     * @param string $field
     * @param mixed $value
     * @param mixed|null $param
     * @return void
     */
    protected function validateRequired(string $field, $value, $param = null): void {
        if (is_null($value) || $value === '' || (is_array($value) && count($value) === 0)) {
            $this->errors[$field][] = __('The :attribute field is required.', 'phonebook');
        }
    }

    /**
     * Validate if the field is a valid email.
     *
     * @param string $field
     * @param mixed $value
     * @param mixed|null $param
     * @return void
     */
    protected function validateEmail(string $field, $value, $param = null): void {
        if ( ! filter_var( $value, FILTER_VALIDATE_EMAIL ) ) {
            $this->errors[$field][] = __('The :attribute must be a valid email address.', 'phonebook');
        }
    }

    /**
     * Validate the minimum length of the field.
     *
     * @param string $field
     * @param mixed $value
     * @param string|null $param
     * @return void
     */
    protected function validateMin( string $field, $value, $param = null ): void {
        if ( is_string( $value ) && strlen( $value ) < (int)$param) {
            $this->errors[$field][] = sprintf(
                /* translators: %d: Minimum number of characters required. */
                __('The :attribute must be at least %d characters.', 'phonebook'),
                $param
            );
        }
    }

    /**
     * Validate the maximum length of the field.
     *
     * @param string $field
     * @param mixed $value
     * @param string|null $param
     * @return void
     */
    protected function validateMax(string $field, $value, $param): void {
        if ( is_string($value) && strlen($value) > (int)$param ) {
            /* translators: %d: Maximum number of characters allowed. */
            $this->errors[$field][] = sprintf(__('The :attribute must not exceed %d characters.', 'phonebook'), $param);
        }
    }

    /**
     * Validate if the field value is one of the allowed options.
     *
     * @param string $field
     * @param mixed $value
     * @param string|null $param
     * @return void
     */
    protected function validateIn(string $field, $value, $param): void {
        $allowed = explode(',', $param);
        if ( ! in_array($value, $allowed)) {
            /* translators: %s: Allowed values. */
            $this->errors[$field][] = sprintf(__('The :attribute must be one of: %s.', 'phonebook'), implode(', ', $allowed));
        }
    }
}

