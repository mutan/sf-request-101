<?php
declare(strict_types=1);

namespace App\Dto\Response;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as Serializer;

/**
 * @package App\Dto
 */
class ErrorResponse
{
    /**
     * @var string
     *
     * @Serializer\SerializedName("message")
     * @Serializer\Type("string")
     */
    protected $message;

    /**
     * @var int|null
     *
     * @Serializer\SerializedName("code")
     * @Serializer\Type("int")
     */
    protected $code;

    /**
     * @var ArrayCollection|Error[]
     *
     * @Serializer\SerializedName("errors")
     * @Serializer\Type("ArrayCollection<App\Dto\Response\Error>")
     */
    protected $errors;

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

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @param int|null $code
     *
     * @return self
     */
    public function setCode(?int $code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return ArrayCollection|Error[]
     */
    public function getErrors(): ArrayCollection
    {
        return $this->errors;
    }

    /**
     * @param ArrayCollection|Error[] $errors
     *
     * @return self
     */
    public function setErrors(ArrayCollection $errors): self
    {
        $this->errors = $errors;

        return $this;
    }
}
