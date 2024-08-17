<?php

namespace App\Models;

use App\Http\Service\VisitorService;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use VisitorService;

    protected $fillable = [
        'name',
        'lastName',
        'status',
        'company',
        'phone',
        'telegram',
        'email',
        'category',
        'isApproved',
        'code'
    ];

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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function getTelegram(): ?string
    {
        return $this->telegram;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function getIsApproved(): bool
    {
        return $this->isApproved;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function setCompany(string $company): void
    {
        $this->company = $company;
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    public function setTelegram(string $telegram): void
    {
        $this->telegram = $telegram;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setCategory(string $category): void
    {
        $this->category = $category;
    }

    public function setIsApproved(bool $isApproved): void
    {
        $this->isApproved = $isApproved;
    }

    public function setCode(): void
    {
        $this->code = $this->createCode();
    }
}
