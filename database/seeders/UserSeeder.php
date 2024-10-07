<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Team;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roleMaster=Role::create([
            'name'=>'master',
            'guard_name'=>'web'
        ]);
        $roleAdmin=Role::create([
            'name'=>'admin',
            'guard_name'=>'web'
        ]);
        $roleGf=Role::create([
            'name'=>'gf',
            'guard_name'=>'web'
        ]);
        $roleDei=Role::create([
            'name'=>'dei',
            'guard_name'=>'web'
        ]);

        $user=User::create([
            'username' => 'master',
            'name' => 'Master',
            'email' => 'maser@example.com',
            'password' => Hash::make('password'),
        ]);
        $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,
            'name' => explode(' ', $user->name, 2)[0]."'s Team",
            'personal_team' => true,
        ]));
        $user->roles()->attach($roleMaster);

        $user=User::create([
            'username' => 'admin',
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
        $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,
            'name' => explode(' ', $user->name, 2)[0]."'s Team",
            'personal_team' => true,
        ]));
        $user->roles()->attach($roleAdmin);

        $user=User::create([
            'username' => 'gf',
            'name' => 'Gf',
            'email' => 'gf@example.com',
            'password' => Hash::make('password'),
        ]);
        $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,
            'name' => explode(' ', $user->name, 2)[0]."'s Team",
            'personal_team' => true,
        ]));
        $user->roles()->attach($roleGf);

        $user=User::create([
            'username' => 'dei',
            'name' => 'Dei',
            'email' => 'dei@example.com',
            'password' => Hash::make('password'),
        ]);
        $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,
            'name' => explode(' ', $user->name, 2)[0]."'s Team",
            'personal_team' => true,
        ]));
        $user->roles()->attach($roleDei);

        $user=User::create([
            'username' => 'member1',
            'name' => 'Member1',
            'email' => 'member1@example.com',
            'password' => Hash::make('password'),
        ]);
        $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,
            'name' => explode(' ', $user->name, 2)[0]."'s Team",
            'personal_team' => true,
        ]));        
        $user=User::create([
            'username' => 'member2',
            'name' => 'Member2',
            'email' => 'member2@example.com',
            'password' => Hash::make('password'),
        ]);
        $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,
            'name' => explode(' ', $user->name, 2)[0]."'s Team",
            'personal_team' => true,
        ]));
        $user=User::create([
            'username' => 'member3',
            'name' => 'Member3',
            'email' => 'member3@example.com',
            'password' => Hash::make('password'),
        ]);
        $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,
            'name' => explode(' ', $user->name, 2)[0]."'s Team",
            'personal_team' => true,
        ]));        
    }
}
