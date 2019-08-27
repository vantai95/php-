<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'Admin',
                'code' => 'admin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'permissions' => 'u1,u2,i1,i2,e1,e2,g1,g2,gt1,gt2,c1,c2,sc1,sc2,m1,m2,sm1,sm2,ct1,ct2,cu1,cu2,co1,co2,r1,r2,p1,p2,pmd1,pmd2,emt1,emt2,w1,w2,au1,au2,il1,il2,or1,or2,fp1,fp2,s1,s2'
            ]
        ];

        if(DB::table('roles')->count() == 0){
            DB::table('roles')->insert($roles);
        }
    }
}
