<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreateUser()
    {
        factory(\App\User::class)->create(['name' => 'Duilio']);

        $this->get('name')
            ->assertResponseOk();

        $this->seeText('Duilio');
    }
}
