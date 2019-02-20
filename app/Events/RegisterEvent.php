<?php

namespace App\Events;

use App\Repositories\UserRepository;
use App\Models\User;

class RegisterEvent extends Event
{
    public $user;
    public $userRep;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(UserRepository $userRep, User $user)
    {
        $this->userRep = $userRep;
        $this->user = $user;
    }
}
