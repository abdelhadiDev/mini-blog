<?php
declare(strict_types=1);

namespace App\Entity;

use DateTimeInterface;
use Symfony\Component\Serializer\Annotation\Groups;

trait Timestampable 
{
    /**
     * @var  DateTimeInterface
     * @ORM\Column(type="datetime")
     * @Groups({"article_read", "article_details_read", "user_read", "user_details_read"})
     */
    private $createdAt;

    /**
     * @var  DateTimeInterface
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"article_read", "article_details_read"})
     */
    private $updatedAt;

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}