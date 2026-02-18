<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class SessionStoredInDatabaseTest extends TestCase
{
    public function test_session_driver_is_database(): void
    {
        $this->assertSame('database', config('session.driver'));
    }

    public function test_sessions_table_exists(): void
    {
        $this->assertTrue(Schema::hasTable('sessions'));
    }
}
