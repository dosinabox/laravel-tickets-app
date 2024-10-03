<?php

namespace App\Http\Requests\Visitor;

use Illuminate\Foundation\Http\FormRequest;

class VisitorRequest extends FormRequest
{
    public function getName(): string
    {
        return $this->get('name', '');
    }

    public function getLastName(): string
    {
        return $this->get('lastName', '');
    }

    public function getStatus(): string
    {
        return $this->get('status', '');
    }

    public function getCompany(): string
    {
        return $this->get('company', '');
    }

    public function getPosition(): string
    {
        return $this->get('position', '');
    }

    public function getPhone(): string
    {
        return $this->get('phone', '');
    }

    public function getTelegram(): string
    {
        return $this->get('telegram', '');
    }

    public function getEmail(): string
    {
        return $this->get('email', '');
    }

    public function getCategory(): string
    {
        return $this->get('category', '');
    }

    public function getIsRejected(): bool
    {
        return $this->get('isRejected', false);
    }

    public function getSearchQuery(): ?string
    {
        return $this->get('query');
    }
}
