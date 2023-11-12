<?php

use App\Models\User;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class CreateAdminUserSeeder extends Seeder
{
/**
* Run the database seeds.
*
* @return void
*/
public function run()
{

         $user = User::create([
        'name' => 'Rabie',
        'email' => 'Rabie@gmail.com',
        'password' => bcrypt('11111111'),
        'roles_name' => ["owner"],
        'Status' => 'مفعل',
        ]);

        $role = Role::create(['name' => 'owner']);

        $permissions = Permission::pluck('id','id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);


}
}
