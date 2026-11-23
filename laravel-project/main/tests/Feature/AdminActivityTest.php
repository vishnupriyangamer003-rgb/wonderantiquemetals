<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\AdminActivity;
use App\Models\Banner;
use Tests\TestCase;

class AdminActivityTest extends TestCase
{
    private function admin(): Admin
    {
        return Admin::create(['username' => 'boss', 'password' => 'secret123']);
    }

    private function asAdmin(): static
    {
        return $this->withSession(['admin_id' => $this->admin()->id]);
    }

    public function test_guests_cannot_open_the_activity_log(): void
    {
        $this->flushSession();
        $this->get('/ktgadmin/activity')->assertRedirect('/ktgadmin');
    }

    public function test_admin_login_and_logout_are_logged(): void
    {
        $this->flushSession();
        $this->admin();

        $this->post('/ktgadmin', ['username' => 'boss', 'password' => 'secret123'])->assertRedirect();
        $this->assertDatabaseHas('admin_activities', ['admin_name' => 'boss', 'action' => 'login']);

        $this->post('/ktgadmin/logout');
        $this->assertDatabaseHas('admin_activities', ['admin_name' => 'boss', 'action' => 'logout']);
    }

    public function test_content_changes_are_logged_with_the_item_name(): void
    {
        $banner = Banner::first();
        $this->asAdmin();

        $this->patch("/ktgadmin/banners/{$banner->id}/toggle");
        $this->assertTrue(AdminActivity::where('action', 'hidden')->orWhere('action', 'shown')->exists());

        $this->delete("/ktgadmin/banners/{$banner->id}");
        $row = AdminActivity::where('action', 'deleted')->first();

        $this->assertNotNull($row);
        $this->assertSame('boss', $row->admin_name);
        $this->assertStringContainsString((string) ($banner->title ?: '#'.$banner->id), $row->description);
    }

    public function test_account_change_is_logged_without_the_password(): void
    {
        $this->asAdmin()->put('/ktgadmin/account', ['username' => 'boss', 'password' => 'brandnewpass99']);

        $this->assertDatabaseHas('admin_activities', ['action' => 'account']);
        $this->assertSame(0, AdminActivity::where('description', 'like', '%brandnewpass99%')->count());
    }

    public function test_page_lists_activity_newest_first_in_indian_time(): void
    {
        $admin = $this->admin();
        AdminActivity::create(['admin_id' => $admin->id, 'admin_name' => 'boss', 'action' => 'created', 'description' => 'Older entry', 'created_at' => now()->subHour()]);
        AdminActivity::create(['admin_id' => $admin->id, 'admin_name' => 'boss', 'action' => 'updated', 'description' => 'Newer entry', 'created_at' => now()]);

        $this->flushSession();
        $this->withSession(['admin_id' => $admin->id])
            ->get('/ktgadmin/activity')
            ->assertOk()
            ->assertSeeInOrder(['Newer entry', 'Older entry'])
            ->assertSee('IST');
    }
}
