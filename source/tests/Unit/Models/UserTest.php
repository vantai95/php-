<?php

namespace Test\Unit\Models;

use Tests\TestCase;
use App\Models\Role;
use App\Models\User;

class UserTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    public function testIsAdmin()
    {
        $role = factory(Role::class)->create();
        $user = factory(User::class)->create([
            'role_id' => $role->id,
        ]);
        $this->assertNotEmpty($user->role_id);
    }

    public function testRoleNameAdmin()
    {
        $role = factory(Role::class)->create();
        $user = factory(User::class)->create([
            'role_id' => $role->id,
        ]);
        $this->assertEquals('Quản Trị',$user->roleName());
    }

    public function testRoleNameUser()
    {
        $user = factory(User::class)->create([
            'role_id' => null,
        ]);
        $this->assertEquals('Người Dùng',$user->roleName());
    }

    public function testStatusLocked()
    {
        $user = factory(User::class)->create([
            'is_locked' => true,
        ]);
        $this->assertEquals('Khóa', $user->status());
    }

    public function testStatusActive()
    {
        $user = factory(User::class)->create([
            'is_locked' => false,
        ]);
        $this->assertEquals('Hoạt Động', $user->status());
    }


    public function testStatusClassLocked()
    {
        $user = factory(User::class)->create([
            'is_locked' => true,
        ]);
        $this->assertEquals('m-badge--danger', $user->status_class());
    }

    public function testStatusClassActive()
    {
        $user = factory(User::class)->create([
            'is_locked' => false,
        ]);
        $this->assertEquals('m-badge--success', $user->status_class());
    }

}


