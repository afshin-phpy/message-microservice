<?php

namespace Tests;

use App\Models\Message;
use Laravel\Lumen\Testing\DatabaseTransactions;

class MessageTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * Database insertion test.
     *
     * @return void
     */
    public function testDatabaseInsertion ()
    {
        //Insert new user to database
        $message = Message::factory()->create();

        // Assert the item was inserted into the database
        $this->seeInDatabase('messages', ['title' => $message->title]);
    }

    /**
     * End-point response test on correct data transmission
     * 
     * @return void
     */
    public function testStoreMessageEndpointWithCorrectData()
    {
        $response = $this->post('/api/message/store', [
            'user_id'   => '10',
            'title'     => 'test',
            'content'   =>  'This is a test content.'
        ]);

        // Assert response
        $response->seeStatusCode(200);
        $response->seeJsonStructure([
            'data' => [
                'status',
                'message'
            ],
            'server_time'
        ]);
    }
}
