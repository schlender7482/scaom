<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    // A ORDEM É IMPORTANTE!
    // 1. Primeiro as permissões (não dependem de nada)
    // 2. Depois os roles (que vão usar as permissões)
    // 3. Por último os users (que precisam dos roles)
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
        ]);
    }
}
