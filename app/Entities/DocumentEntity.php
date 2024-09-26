<?php

namespace App\Entities;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use LLPhant\Embeddings\VectorStores\Doctrine\DoctrineEmbeddingEntityBase;
use LLPhant\Embeddings\VectorStores\Doctrine\VectorType;

#[Entity]
#[Table(name: 'documents')]
class DocumentEntity extends DoctrineEmbeddingEntityBase
{
    #[ORM\Column(type: VectorType::VECTOR, length: 768)]
    public ?array $embedding;

    #[ORM\Column(type: Types::INTEGER)]
    public $user_id;

    public function setUserId($userId): self
    {
        $this->user_id = $userId;
        return $this;
    }

    public function getUser(): string
    {
        return $this->user_id;
    }
}
