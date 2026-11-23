<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    // phpunit.xml forces an in-memory SQLite database, so MySQL is never touched.
    use RefreshDatabase;

    protected bool $seed = true;

    protected function setUp(): void
    {
        parent::setUp();

        // Public pages sit behind the OTP login (SiteAuth); tests start signed in.
        // Gate tests can call $this->flushSession() to act as a guest.
        $this->withSession(['site_login' => true]);
    }
}
