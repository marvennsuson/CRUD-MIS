<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class UserGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $users = [
            [
                'user_group' => 'Admin',
                'level' => 9

            ],
            [
                'user_group' => 'LGU Admin',
                'level' => 8

            ],
            [
                'user_group' => 'Residents',
                'level' => 1

            ],
            [
                'user_group' => 'BPLO ADMIN',
                'level' => 7

            ],
            [
                'user_group' => 'TREASURY ADMIN',
                'level' => 6
                
            ],
            [
                'user_group' => 'LAND TAX DIVISION',
                'level' => 5
                
            ],

        ];


        DB::table('user_groups')->insert($users);

        // DB::table('user_groups')->insert(
        //     [

        //     ],
        //     [
        //         'user_group' => 'Normal Users',
        //         'user_level' => 1,
        //     ]
        // );
    }
}
