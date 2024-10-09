<?php

namespace App\Models;

use App\Http\Service\VisitorService;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use VisitorService;

    public const CATEGORY_GUEST = 'Гость';
    public const CATEGORY_EMPLOYEE = 'Сотрудник';
    public const CATEGORY_VIP = 'VIP';
    public const CATEGORY_PRESS = 'СМИ';
    public const CATEGORY_UNKNOWN = 'Без категории';

    public const STATUS_VALIDATED = 'Билет использован';

    protected $fillable = [
        'name',
        'lastName',
        'company',
        'position',
        'phone',
        'telegram',
        'email',
        'category',
        'isRejected',
        'status',
        'code'
    ];

    public function getID(): int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function getTelegram(): ?string
    {
        return $this->telegram ? '@' . $this->telegram : null;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getCategory(): string
    {
        return $this->category ?? self::CATEGORY_UNKNOWN;
    }

    public function isRejected(): bool
    {
        return $this->isRejected;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getCreatedAt(): string
    {
        return date_create($this->created_at)->format('d.m.Y H:i');
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function setLastName(?string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

    public function setCompany(?string $company): void
    {
        $this->company = $company;
    }

    public function setPosition(?string $position): void
    {
        $this->position = $position;
    }

    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    public function setTelegram(?string $telegram): void
    {
        $this->telegram = $telegram ? str_replace('@', '', $telegram) : null;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function setCategory(?string $category): void
    {
        $this->category = $category ?? self::CATEGORY_UNKNOWN;
    }

    public function setIsRejected(bool $isRejected): void
    {
        $this->isRejected = $isRejected;
    }

    public function setCode(): void
    {
        $this->code = $this->createCode();
    }

    public function serialize(): array
    {
        return [
            'id' => $this->getID(),
            'name' => $this->getName(),
            'lastName' => $this->getLastName(),
            'company' => $this->getCompany(),
            'position' => $this->getPosition(),
            'phone' => $this->getPhone(),
            'telegram' => $this->getTelegram(),
            'email' => $this->getEmail(),
            'category' => $this->getCategory(),
            'isRejected' => $this->isRejected(),
            'status' => $this->getStatus(),
            'code' => $this->getCode(),
            'created_at' => $this->getCreatedAt(),
        ];
    }
}
