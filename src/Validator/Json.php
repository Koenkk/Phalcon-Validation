<?php

namespace BasilFX\Validation\Validator;

use Phalcon\Messages\Message;
use Phalcon\Validation\AbstractValidator;

use JsonSchema;

/**
 * JSON Schema validator.
 *
 * Given a JSON-compatible data structure, validate it against the provided
 * schema. It uses the JsonSchema library for validation.
 */
class Json extends AbstractValidator
{
    /**
     * @inheritdoc
     */
    public function validate(\Phalcon\Validation $validation, $field): bool
    {
        // Create a new JSON schema validator.
        $factory = new JsonSchema\Constraints\Factory();
        $validator = new JsonSchema\Validator($factory);

        $validator->check(
            $validation->getValue($field),
            (object) ["\$ref" => $this->getOption("schema")]
        );

        // Handle the case where the data does not match.
        if (!$validator->isValid()) {
            $message = $this->getOption("message");

            if (!$message) {
                $message = (
                    "The JSON structure did not validate against provided " .
                    "schema."
                );
            }

            $validation->appendMessage(
                new Message($message, $field, "Json")
            );

            return false;
        }

        return true;
    }
}
