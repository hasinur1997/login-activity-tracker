<?php
namespace Hasinur\LoginActivityTracker\Requests;

use Hasinur\LoginActivityTracker\Validation\Validator;

/**
 * Class FormRequest
 * Base request class for handling validation and authorization.
 */
abstract class FormRequest {
    /**
     * The request input data.
     *
     * @var array
     */
    protected array $data = [];

    /**
     * The validation errors.
     *
     * @var array
     */
    protected array $errors = [];

    /**
     * Indicates if validation was run.
     *
     * @var bool
     */
    protected bool $validated = false;

    /**
     * FormRequest constructor.
     *
     * @param array|null $data Optional data for testing or internal use.
     */
    public function __construct(?array $data = null) {
        $this->data = $data ?? $this->resolveInput();
    }

    /**
     * Resolve data from the current HTTP request.
     *
     * @return array
     */
    protected function resolveInput(): array {
        return json_decode(file_get_contents('php://input'), true) ?? [];
    }

    /**
     * Define the validation rules.
     *
     * @return array
     */
    abstract public function rules(): array;

    /**
     * Authorize the request.
     * Override to implement custom authorization logic.
     *
     * @return bool
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * Run authorization and validation.
     *
     * @return bool
     */
    public function validate(): bool {
        if ( ! $this->authorize() ) {
            $this->errors = ['unauthorized' => [ __('This action is unauthorized.', 'phonebook') ] ];
            return false;
        }

        $validator = new Validator($this->data, $this->rules());

        if ( $validator->fails() ) {
            $this->errors = $validator->errors();
            return false;
        }

        $this->validated = true;
        return true;
    }

    /**
     * Get the validated input data.
     *
     * @return array
     */
    public function validated(): array {
        return $this->validated ? $this->data : [];
    }

    /**
     * Get a specific input key.
     *
     * @param   string  $key  The input key.
     *
     * @return  mixed         The input value or null if not found.
     */
    public function __get($key) {
        return $this->input($key);
    }

    /**
     * Get validation errors.
     *
     * @return array
     */
    public function errors(): array {
        return $this->errors;
    }

    /**
     * Get a specific input key.
     *
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    public function input(string $key, mixed $default = null): mixed {
        return $this->data[$key] ?? $default;
    }

    /**
     * Get all input data.
     *
     * @return array
     */
    public function all(): array {
        return $this->data;
    }
}
