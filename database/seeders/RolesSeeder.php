<?php

namespace Database\Seeders;

use App\Services\AuthService;
use App\Models\User;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function run(): void
    {
        // 1. Setup Roles & Permissions
        $this->authService->setupRolesAndPermissions();

        // 2. Assigni l-Admin role l-dik l-compte li creyina f-DatabaseSeeder
        $adminUser = User::where('email', 'austriapatrick73@gmail.com')->first();
        if ($adminUser) {
            $this->authService->assignRoleToUser($adminUser, 'admin');
        }
    }
}