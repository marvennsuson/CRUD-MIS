<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            'username' => 'Admin',
            'email' => 'admin@lgu.com',
            'password' => Hash::make('Admin1969'),
            'firstname' => "admin",
            'middlename' => "lgu",
            'lastname' => "local",
            'exname' => "Sr",
            'gender' => "Male",
            'age' => "31",
            'dob' => "02/09/1999",
            'address' => "Anounymouse",
            'mobile' => "09123456789",
            'province' => "Ifugao",
            'city' => "Magsasay",
            'postalcode' => "123465",
            'barangay' => "tala",
            'housenumber' => "321",
            'streetname' => "Larosa",
            'otherinfo' => "None",
            'avatar' => "",
            'user_level' => 9,
            'visibility' => 1
        ];
        DB::table('users')->insert($users);

        $users = [
            'email' => 'niellevince@gmail.com',
            'password' => Hash::make('nartel650'),
            'firstname' => "Nielle Vince",
            'middlename' => "Jucaban",
            'lastname' => "Letran",
            'exname' => "",
            'gender' => "Male",
            'age' => "21",
            'dob' => "02/14/1999",
            'address' => "Block 161, Lot 3, Visayas Street, Central Bicutan, Taguig City, Metro Manila",
            'mobile' => "09123456789",
            'province' => "Metro Manila",
            'city' => "Taguig",
            'postalcode' => "1630",
            'barangay' => "Central Bicutan",
            'housenumber' => "Block 161 Lot 3",
            'streetname' => "Visayas Street",
            'otherinfo' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.",
            'avatar' => "",
            'visibility' => 1,
            'verify' => 1,
    ];
    DB::table('residents')->insert($users);

    
    }
}
