<?php

namespace OpenVoid\Validator;

use OpenVoid\Validator\Validators\ValidatorInterface;

use InvalidArgumentException;
use function get_class;
use function gettype;
use function is_array;
use function is_object;
use function sprintf;

final class Validator
{
    /**
     * @var array<string,array>
     */
    private $validators;

    /**
     * @var array<string,string>
     */
    private $errors = [];

    /**
     * @var array
     */
    private $data = [];

    public function __construct(array $field_validators)
    {
        foreach ($field_validators as $field => $validators) {
            if (! is_array($validators)) {
                $validators = [$validators];
            }

            $this->add_validator($field, $validators);
        }
    }

    public function validate(array $data) : bool
    {
        $this->data = $data;

        /**
         * @var $validators array<ValidatorInterface>
         */
        foreach ($this->validators as $field => $validators) {
            if (! isset($this->data[$field])) {
                $this->data[$field] = null;
            }

            foreach ($validators as $validator) {
                if ($validator->validate($this->data[$field]) === false) {
                    $this->add_error($field, (string) $validator->get_error());
                }
            }
        }

        return $this->get_errors() === [];
    }

    /**
     * @return array<string,string>
     */
    public function get_errors() : array
    {
        return $this->errors;
    }

    /**
     * @return array
     */
    public function get_data() : array
    {
        return $this->data;
    }

    private function add_error(string $field, string $message) : void
    {
        $this->errors[$field][] = $message;
    }

    /**
     * @param string $field
     * @param array<ValidatorInterface> $validators
     * @return void
     */
    private function add_validator(string $field, array $validators) : void
    {
        foreach ($validators as $validator) {
            if (! $validator instanceof ValidatorInterface) {
                throw new InvalidArgumentException(sprintf(
                    $field . ' validator must be an instance of ValidatorInterface, "%s" given.',
                    is_object($validator) ? get_class($validator) : gettype($validator)
                ));
            }

            $this->validators[$field][] = $validator;
        }
    }
}
