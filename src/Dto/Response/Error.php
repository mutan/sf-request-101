<?php
declare(strict_types=1);

namespace App\Dto\Response;

use JMS\Serializer\Annotation as Serializer;

/**
 * @package App\Dto\Response
 */
class Error
{
    /**
     * @var string|null
     *
     * @Serializer\SerializedName("field")
     * @Serializer\Type("string")
     */
    protected $field;

    /**
     * @var string
     *
     * @Serializer\SerializedName("message")
     * @Serializer\Type("string")
     */
    protected $message;

    /**
     * @return string
     */
    public function getField(): string
    {
        return $this->field;
    }

    /**
     * Error constructor.
     *
     * @param string      $message
     * @param string|null $field
     */
    public function __construct(string $message, ?string $field = null)
    {
        $this->message = $message;
        $this->field = $field;
    }

    /**
     * @param string $field
     *
     * @return self
     */
    public function setField(string $field): self
    {
        $this->field = $field;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     *
     * @return self
     */
    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }
}
