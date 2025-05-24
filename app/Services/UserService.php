<?php
namespace App\Services;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;

class UserService
{
    public function createUser(array $data)
    {
        return User::create([
            'id' => Uuid::uuid4()->toString(),
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'] ?? 'staff',
            'status' => $data['status'] ?? true,
        ]);
    }
}
