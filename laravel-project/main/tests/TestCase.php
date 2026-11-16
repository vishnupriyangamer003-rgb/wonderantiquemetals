<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    // phpunit.xml forces an in-memory SQLite database, so MySQL is never touched.
    use RefreshDatabase;

    protected bool $seed = true;
}
