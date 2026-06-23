<?php

namespace Database\Seeders;

use App\Models\Gallery as ModelsGallery;
use App\Models\Iphones;
use App\Models\Payment;
use App\Models\Revenue;
use App\Models\User;
use Database\Factories\FaqFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $roles = ['super-admin', 'admin'];

        $this->call([
            PermissionSeeder::class,
            RolesSeeder::class
        ]);

        foreach ($roles as $role) {
            $user = User::factory()->create([
                'name' => $role,
                'email' => $role . '@example.com',
                'password' => Hash::make('123456')
            ]);

            $user->assignRole($role);
        }

        ModelsGallery::factory(10)->create();
        #Iphones::factory(10)->create();
        Revenue::factory()->count(5)->create();
        FaqFactory::new()->count(5)->create([
            'created_by' => User::factory()->create()->id,
            'updated_by' => User::factory()->create()->id,
        ]);
        Payment::factory()->count(5)->create();
    }
}
