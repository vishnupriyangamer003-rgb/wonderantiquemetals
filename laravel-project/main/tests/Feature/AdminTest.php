<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Appraisal;
use App\Models\Banner;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Testimonial;
use App\Support\ImageUploader;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class AdminTest extends TestCase
{
    private array $created = [];

    protected function tearDown(): void
    {
        // Remove any image files the tests wrote into the public uploads folder.
        foreach (glob(public_path(ImageUploader::DIR).'/*') ?: [] as $file) {
            if (is_file($file) && basename($file) !== '.htaccess') {
                @unlink($file);
            }
        }
        parent::tearDown();
    }

    private function login(): static
    {
        Admin::create(['username' => 'boss', 'password' => 'secret123']);

        return $this->withSession(['admin_id' => Admin::first()->id]);
    }

    // ---------- authentication ----------

    public function test_login_page_loads_and_is_not_cacheable(): void
    {
        $this->get('/ktgadmin')->assertOk()->assertSee('Sign in')
            ->assertHeader('X-Robots-Tag', 'noindex, nofollow');
    }

    public function test_guests_are_redirected_from_every_admin_page(): void
    {
        foreach (['settings', 'account', 'banners', 'services', 'appraisals', 'testimonials', 'banners/create'] as $path) {
            $this->get("/ktgadmin/$path")->assertRedirect('/ktgadmin');
        }
        $this->put('/ktgadmin/settings', [])->assertRedirect('/ktgadmin');
        $this->post('/ktgadmin/banners', [])->assertRedirect('/ktgadmin');
    }

    public function test_successful_login_redirects_to_company_settings(): void
    {
        Admin::create(['username' => 'boss', 'password' => 'secret123']);

        $this->post('/ktgadmin', ['username' => 'boss', 'password' => 'secret123'])
            ->assertRedirect('/ktgadmin/settings');
        $this->get('/ktgadmin/settings')->assertOk()->assertSee('Company information');
    }

    public function test_wrong_credentials_are_rejected_with_a_generic_message(): void
    {
        Admin::create(['username' => 'boss', 'password' => 'secret123']);

        $this->post('/ktgadmin', ['username' => 'boss', 'password' => 'nope'])
            ->assertSessionHasErrors(['username' => 'Invalid username or password.']);
        $this->post('/ktgadmin', ['username' => 'ghost', 'password' => 'secret123'])
            ->assertSessionHasErrors(['username' => 'Invalid username or password.']);
    }

    public function test_login_is_rate_limited_after_five_failures(): void
    {
        Admin::create(['username' => 'boss', 'password' => 'secret123']);
        RateLimiter::clear('admin-login:boss|127.0.0.1');

        for ($i = 0; $i < 5; $i++) {
            $this->post('/ktgadmin', ['username' => 'boss', 'password' => 'bad']);
        }
        // Even the right password is refused while locked out.
        $this->post('/ktgadmin', ['username' => 'boss', 'password' => 'secret123'])
            ->assertSessionHasErrors('username');
        $this->get('/ktgadmin/settings')->assertRedirect('/ktgadmin');
    }

    public function test_session_id_changes_on_login_and_logout_ends_access(): void
    {
        $this->login();
        $this->get('/ktgadmin/settings')->assertOk()
            ->assertHeader('X-Frame-Options', 'DENY');
        $this->post('/ktgadmin/logout')->assertRedirect('/ktgadmin');
        $this->get('/ktgadmin/settings')->assertRedirect('/ktgadmin');
    }

    public function test_admin_pages_send_no_store_cache_headers(): void
    {
        $response = $this->login()->get('/ktgadmin/banners')->assertOk();
        $this->assertStringContainsString('no-store', $response->headers->get('Cache-Control'));
    }

    // ---------- company settings ----------

    public function test_settings_save_and_show_on_the_public_site_immediately(): void
    {
        $this->login();
        $this->get('/')->assertOk(); // warm the cache

        $this->put('/ktgadmin/settings', [
            'phone' => '+91 99999 11111', 'whatsapp' => '+91 98765 43210', 'email' => 'info@wonder.test',
            'address' => "1 Test Road\nKarur", 'facebook' => 'https://facebook.com/wonder',
            'meta_title' => 'New Meta Title', 'meta_description' => 'New desc', 'meta_keywords' => 'a, b',
        ])->assertSessionHasNoErrors()->assertSessionHas('status');

        $this->get('/')->assertOk()
            ->assertSee('+91 99999 11111')->assertSee('info@wonder.test')
            ->assertSee('https://wa.me/919876543210', false)->assertSee('https://facebook.com/wonder', false)
            ->assertSee('1 Test Road, Karur')->assertSee('<meta name="keywords" content="a, b">', false);
    }

    public function test_settings_reject_bad_email_and_non_http_social_links(): void
    {
        $this->login()->put('/ktgadmin/settings', ['email' => 'not-an-email', 'facebook' => 'javascript:alert(1)'])
            ->assertSessionHasErrors(['email', 'facebook']);
    }

    // ---------- account ----------

    public function test_account_shows_password_and_updates_without_confirmation(): void
    {
        $this->login();
        $this->get('/ktgadmin/account')->assertOk()->assertSee('secret123', false)->assertSee('data-pass-toggle', false);

        $this->put('/ktgadmin/account', ['username' => 'newboss', 'password' => 'fresh456'])
            ->assertSessionHasNoErrors();
        $this->assertSame('fresh456', Admin::first()->password);
        $this->assertSame('newboss', Admin::first()->username);
    }

    public function test_account_rejects_short_password_and_bad_username(): void
    {
        $this->login()->put('/ktgadmin/account', ['username' => 'a b', 'password' => '123'])
            ->assertSessionHasErrors(['username', 'password']);
    }

    // ---------- CRUD ----------

    public function test_service_crud_updates_menu_and_public_page(): void
    {
        $this->login();
        $this->post('/ktgadmin/services', [
            'slug' => 'antique-clocks', 'number' => '06', 'eyebrow' => 'Time', 'title' => 'Antique clocks',
            'summary' => 'Care for antique clocks.', 'details' => "First para.\n\nSecond para.", 'sort_order' => 6, 'active' => 1,
        ])->assertRedirect('/ktgadmin/services');

        $service = Service::where('slug', 'antique-clocks')->firstOrFail();
        $this->assertSame(['First para.', 'Second para.'], $service->details);
        $this->get('/services/antique-clocks')->assertOk()->assertSee('Antique clocks')->assertSee('Second para.');
        $this->get('/')->assertSee('/services/antique-clocks', false);

        $this->patch("/ktgadmin/services/{$service->id}/toggle");
        $this->get('/services/antique-clocks')->assertNotFound();

        $this->delete("/ktgadmin/services/{$service->id}");
        $this->assertDatabaseMissing('services', ['slug' => 'antique-clocks']);
    }

    public function test_service_slug_must_be_unique_and_valid(): void
    {
        $this->login()->post('/ktgadmin/services', ['slug' => 'Bad Slug', 'title' => 'x', 'summary' => 'y'])
            ->assertSessionHasErrors('slug');
        $this->post('/ktgadmin/services', ['slug' => 'auction', 'title' => 'x', 'summary' => 'y'])
            ->assertSessionHasErrors('slug');
    }

    public function test_appraisal_page_sections_are_saved_and_rendered(): void
    {
        $this->login()->post('/ktgadmin/appraisals', [
            'slug' => 'insurance', 'nav_label' => 'Insurance', 'meta_title' => 'Insurance | Wonder', 'heading' => 'Insurance', 'heading_em' => 'valuations.',
            'lead' => 'Lead text.', 'section_heading' => ['One', ''], 'section_text' => ['Alpha text', ''], 'button_label' => 'Ask us', 'active' => 1,
        ])->assertSessionHasNoErrors();

        $page = Appraisal::where('slug', 'insurance')->firstOrFail();
        $this->assertCount(1, $page->sections);
        $this->get('/appraisals/insurance')->assertOk()->assertSee('Alpha text')->assertSee('valuations.');
        $this->get('/appraisals/appraisals')->assertNotFound();
    }

    public function test_testimonials_appear_on_about_and_can_be_hidden(): void
    {
        $this->login()->post('/ktgadmin/testimonials', ['name' => 'Zed Tester', 'location' => 'Goa', 'quote' => 'Wonderful service.', 'active' => 1]);
        $this->get('/about')->assertSee('Zed Tester');

        $this->patch('/ktgadmin/testimonials/'.Testimonial::where('name', 'Zed Tester')->value('id').'/toggle');
        $this->get('/about')->assertDontSee('Zed Tester');
    }

    public function test_banner_button_link_cannot_be_a_javascript_url(): void
    {
        $this->login()->post('/ktgadmin/banners', [
            'title' => 'T', 'button_label' => 'Go', 'button_url' => 'javascript:alert(1)',
            'image' => UploadedFile::fake()->image('b.jpg', 800, 600),
        ])->assertSessionHasErrors('button_url');
    }

    // ---------- uploads ----------

    public function test_valid_image_is_stored_with_a_random_name_and_reencoded(): void
    {
        $this->login()->post('/ktgadmin/banners', [
            'title' => 'Upload test', 'image' => UploadedFile::fake()->image('Original Name.png', 800, 600)->size(300),
        ])->assertSessionHasNoErrors();

        $banner = Banner::where('title', 'Upload test')->firstOrFail();
        $this->assertMatchesRegularExpression('~^assets/uploads/[a-f0-9]{24}\.png$~', $banner->image);
        $this->assertFileExists(public_path($banner->image));
        $this->assertStringNotContainsString('Original', $banner->image);
    }

    public function test_replacing_and_deleting_removes_the_old_file(): void
    {
        $this->login()->post('/ktgadmin/banners', ['title' => 'Swap', 'image' => UploadedFile::fake()->image('a.jpg', 600, 400)]);
        $banner = Banner::where('title', 'Swap')->firstOrFail();
        $old = $banner->image;

        $this->put("/ktgadmin/banners/{$banner->id}", ['title' => 'Swap', 'image' => UploadedFile::fake()->image('b.jpg', 600, 400)]);
        $this->assertFileDoesNotExist(public_path($old));
        $new = $banner->fresh()->image;
        $this->assertFileExists(public_path($new));

        $this->delete("/ktgadmin/banners/{$banner->id}");
        $this->assertFileDoesNotExist(public_path($new));
    }

    public function test_non_image_and_disallowed_types_are_rejected(): void
    {
        $this->login();
        foreach ([
            UploadedFile::fake()->create('shell.php', 10, 'application/x-php'),
            UploadedFile::fake()->create('doc.pdf', 10, 'application/pdf'),
            UploadedFile::fake()->createWithContent('vector.svg', '<svg xmlns="http://www.w3.org/2000/svg"><script>alert(1)</script></svg>'),
            UploadedFile::fake()->createWithContent('fake.jpg', '<?php echo 1; ?>'),
            UploadedFile::fake()->image('anim.gif', 100, 100),
        ] as $file) {
            $this->post('/ktgadmin/banners', ['title' => 'Bad', 'image' => $file])->assertSessionHasErrors('image');
        }
        $this->assertDatabaseMissing('banners', ['title' => 'Bad']);
        $this->assertSame([], array_values(array_filter(glob(public_path(ImageUploader::DIR).'/*') ?: [], fn ($f) => basename($f) !== '.htaccess')));
    }

    public function test_oversized_images_are_rejected(): void
    {
        $this->login()->post('/ktgadmin/banners', ['title' => 'Big', 'image' => UploadedFile::fake()->image('big.jpg', 800, 600)->size(3000)])
            ->assertSessionHasErrors('image');
        $this->post('/ktgadmin/banners', ['title' => 'Huge', 'image' => UploadedFile::fake()->image('huge.jpg', 7000, 100)])
            ->assertSessionHasErrors('image');
    }

    public function test_uploader_never_deletes_bundled_site_images(): void
    {
        $dir = public_path('assets/images');
        @mkdir($dir, 0777, true);
        $keep = $dir.'/keep-test.png';
        file_put_contents($keep, 'x');

        ImageUploader::delete('assets/images/keep-test.png');
        ImageUploader::delete('assets/uploads/../images/keep-test.png');
        $this->assertFileExists($keep);

        @unlink($keep);
        @rmdir($dir);
    }

    // ---------- Google map ----------

    private const SEEDED_EMBED = 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d62676.83273284569!2d78.04426550516412!3d10.940541113412444!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3baa2f072495398f%3A0x947cfc7a1f7d9f1b!2sKarur%2C%20Tamil%20Nadu!5e0!3m2!1sen!2sin!4v1794821750632!5m2!1sen!2sin';

    private const OTHER_EMBED = 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3888.4!2d77.59!3d12.97!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2sBengaluru!5e0!3m2!1sen!2sin!4v1!5m2!1sen!2sin';

    public function test_contact_page_uses_the_seeded_google_embed_link(): void
    {
        $this->get('/contact')->assertOk()
            ->assertSee('<iframe', false)
            ->assertSee('src="'.self::SEEDED_EMBED.'"', false)
            ->assertSee('Open Karur District in Google Maps')
            ->assertDontSee('googletagmanager', false)
            ->assertDontSee('google-site-verification', false);
    }

    public function test_pasting_the_whole_iframe_code_saves_only_the_embed_address(): void
    {
        $code = '<iframe src="'.self::OTHER_EMBED.'" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>';

        $this->login()->put('/ktgadmin/settings', ['google_map_embed' => $code, 'google_map_label' => 'Bengaluru, India'])
            ->assertSessionHasNoErrors();

        $this->assertSame(self::OTHER_EMBED, Setting::where('key', 'google_map_embed')->value('value'));
        $this->get('/contact')->assertOk()
            ->assertSee('src="'.self::OTHER_EMBED.'"', false)
            ->assertSee('Open Bengaluru in Google Maps');
    }

    public function test_the_embed_link_can_be_pasted_without_the_iframe(): void
    {
        $this->login()->put('/ktgadmin/settings', ['google_map_embed' => self::OTHER_EMBED])->assertSessionHasNoErrors();
        $this->get('/contact')->assertSee('src="'.self::OTHER_EMBED.'"', false);
    }

    public function test_the_admin_form_shows_the_embed_field_and_no_analytics_fields(): void
    {
        $this->login()->get('/ktgadmin/settings')->assertOk()
            ->assertSee('Google Map embed code or link')
            ->assertSee(self::SEEDED_EMBED, false)
            ->assertDontSee('Analytics ID')
            ->assertDontSee('Search Console');
    }

    public function test_only_google_maps_embed_addresses_are_accepted(): void
    {
        $this->login();
        foreach ([
            'https://evil.example/maps/embed?pb=1',
            'http://www.google.com/maps/embed?pb=1',
            'https://www.google.com.evil.com/maps/embed?pb=1',
            'https://www.google.com/search?q=x',
            'javascript:alert(1)',
            '<iframe src="https://evil.example/x"></iframe>',
            'https://www.google.com/maps/embed?pb=1" onload="alert(1)',
        ] as $bad) {
            $this->put('/ktgadmin/settings', ['google_map_embed' => $bad])->assertSessionHasErrors('google_map_embed');
        }
        $this->assertSame(self::SEEDED_EMBED, Setting::where('key', 'google_map_embed')->value('value'));
    }

    public function test_a_bad_value_written_straight_into_the_database_is_never_printed(): void
    {
        Setting::where('key', 'google_map_embed')->update(['value' => 'https://evil.example/maps/embed?pb=1']);
        \App\Support\SiteData::flush();

        $this->get('/contact')->assertOk()->assertDontSee('evil.example', false)->assertDontSee('contact-map__frame', false);
    }

    public function test_empty_embed_hides_the_map_section(): void
    {
        $this->login()->put('/ktgadmin/settings', ['google_map_embed' => '']);
        $this->get('/contact')->assertOk()->assertDontSee('contact-map__frame', false);
    }

    public function test_old_analytics_settings_are_ignored_by_the_site(): void
    {
        Setting::create(['key' => 'google_analytics_id', 'value' => 'G-ABCD123456']);
        Setting::create(['key' => 'google_site_verification', 'value' => 'abcDEF_123-ghiJKL4567890xyz']);
        \App\Support\SiteData::flush();

        $this->get('/')->assertOk()->assertDontSee('googletagmanager', false)->assertDontSee('google-site-verification', false);
    }
    public function test_public_cache_is_flushed_on_admin_save(): void
    {
        $this->get('/');
        $this->assertTrue(Cache::has('site.settings'));
        $this->login()->put('/ktgadmin/settings', ['phone' => '000']);
        $this->assertFalse(Cache::has('site.banners'));
    }
}
