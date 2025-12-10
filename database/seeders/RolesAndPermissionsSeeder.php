<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\User\UserProfile;
use Illuminate\Support\Facades\Hash;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions for a gaming community forum
        $permissions = [
            // Forum Permissions
            'view forums',
            'view threads',
            'view posts',
            'create threads',
            'reply to threads',
            'edit own posts',
            'delete own posts',
            'edit any post',
            'delete any post',
            'lock threads',
            'unlock threads',
            'pin threads',
            'move threads',
            'merge threads',
            'split threads',
            
            // User Permissions
            'view profiles',
            'edit own profile',
            'edit any profile',
            'ban users',
            'warn users',
            'view warnings',
            'manage user groups',
            
            // Moderation Permissions
            'view reports',
            'handle reports',
            'view mod queue',
            'approve posts',
            'soft delete posts',
            'restore posts',
            'permanently delete posts',
            
            // Admin Permissions
            'access admin panel',
            'manage forums',
            'manage categories',
            'manage permissions',
            'manage roles',
            'view system logs',
            'manage settings',
            'manage backups',
            
            // Community Permissions
            'create polls',
            'vote in polls',
            'react to posts',
            'use signatures',
            'use avatars',
            'send private messages',
            'create profile posts',
            'follow users',
            'view member list',
            'search forums',
            
            // Gaming Specific
            'manage clans',
            'create tournaments',
            'manage tournaments',
            'view leaderboards',
            'submit scores',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles based on vBulletin structure
        
        // Administrator - Full access
        $adminRole = Role::create(['name' => 'Administrator']);
        $adminRole->givePermissionTo(Permission::all());
        
        // Super Moderator - Almost full moderation access
        $superModRole = Role::create(['name' => 'Super Moderator']);
        $superModRole->givePermissionTo([
            'view forums', 'view threads', 'view posts',
            'create threads', 'reply to threads',
            'edit own posts', 'delete own posts',
            'edit any post', 'delete any post',
            'lock threads', 'unlock threads', 'pin threads',
            'move threads', 'merge threads', 'split threads',
            'view profiles', 'edit own profile',
            'ban users', 'warn users', 'view warnings',
            'view reports', 'handle reports',
            'view mod queue', 'approve posts',
            'soft delete posts', 'restore posts',
            'create polls', 'vote in polls', 'react to posts',
            'use signatures', 'use avatars',
            'send private messages', 'create profile posts',
            'follow users', 'view member list', 'search forums',
            'view leaderboards', 'submit scores',
        ]);
        
        // Moderator - Standard moderation access
        $modRole = Role::create(['name' => 'Moderator']);
        $modRole->givePermissionTo([
            'view forums', 'view threads', 'view posts',
            'create threads', 'reply to threads',
            'edit own posts', 'delete own posts',
            'edit any post', 'delete any post',
            'lock threads', 'unlock threads', 'pin threads',
            'move threads',
            'view profiles', 'edit own profile',
            'warn users', 'view warnings',
            'view reports', 'handle reports',
            'view mod queue', 'approve posts',
            'soft delete posts', 'restore posts',
            'create polls', 'vote in polls', 'react to posts',
            'use signatures', 'use avatars',
            'send private messages', 'create profile posts',
            'follow users', 'view member list', 'search forums',
            'view leaderboards', 'submit scores',
        ]);
        
        // VIP Member - Premium features
        $vipRole = Role::create(['name' => 'VIP Member']);
        $vipRole->givePermissionTo([
            'view forums', 'view threads', 'view posts',
            'create threads', 'reply to threads',
            'edit own posts', 'delete own posts',
            'view profiles', 'edit own profile',
            'create polls', 'vote in polls', 'react to posts',
            'use signatures', 'use avatars',
            'send private messages', 'create profile posts',
            'follow users', 'view member list', 'search forums',
            'manage clans', 'create tournaments',
            'view leaderboards', 'submit scores',
        ]);
        
        // Clan Leader - Clan management permissions
        $clanLeaderRole = Role::create(['name' => 'Clan Leader']);
        $clanLeaderRole->givePermissionTo([
            'view forums', 'view threads', 'view posts',
            'create threads', 'reply to threads',
            'edit own posts', 'delete own posts',
            'view profiles', 'edit own profile',
            'create polls', 'vote in polls', 'react to posts',
            'use signatures', 'use avatars',
            'send private messages', 'create profile posts',
            'follow users', 'view member list', 'search forums',
            'manage clans',
            'view leaderboards', 'submit scores',
        ]);
        
        // Tournament Organizer - Tournament management
        $tournamentOrgRole = Role::create(['name' => 'Tournament Organizer']);
        $tournamentOrgRole->givePermissionTo([
            'view forums', 'view threads', 'view posts',
            'create threads', 'reply to threads',
            'edit own posts', 'delete own posts',
            'view profiles', 'edit own profile',
            'create polls', 'vote in polls', 'react to posts',
            'use signatures', 'use avatars',
            'send private messages', 'create profile posts',
            'follow users', 'view member list', 'search forums',
            'create tournaments', 'manage tournaments',
            'view leaderboards', 'submit scores',
        ]);
        
        // Registered Member - Standard user
        $memberRole = Role::create(['name' => 'Registered']);
        $memberRole->givePermissionTo([
            'view forums', 'view threads', 'view posts',
            'create threads', 'reply to threads',
            'edit own posts', 'delete own posts',
            'view profiles', 'edit own profile',
            'create polls', 'vote in polls', 'react to posts',
            'use signatures', 'use avatars',
            'send private messages', 'create profile posts',
            'follow users', 'view member list', 'search forums',
            'view leaderboards', 'submit scores',
        ]);
        
        // Guest - Read-only access (for reference, but not assigned)
        $guestRole = Role::create(['name' => 'Guest']);
        $guestRole->givePermissionTo([
            'view forums', 'view threads', 'view posts',
            'view profiles', 'view member list', 'search forums',
            'view leaderboards',
        ]);

        // Create the first admin user
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // Create profile for admin user if it doesn't exist
        if (!$adminUser->profile) {
            UserProfile::create([
                'user_id' => $adminUser->id,
                'user_title' => 'Site Administrator',
                'xp' => 10000,
                'level' => 100,
                'karma' => 1000,
            ]);
        }

        // Assign admin role to the first user
        $adminUser->assignRole('Administrator');

        $this->command->info('Roles and permissions seeded successfully!');
        $this->command->info('Admin user created: admin@example.com / password');
    }
}
