<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class SiteTest extends TestCase
{
    /** @return array<string, array{string, string}> */
    public static function pages(): array
    {
        return [
            'home' => ['/', 'Precious'],
            'about' => ['/about', 'Welcome'],
            'services' => ['/services', 'Our'],
            'contact' => ['/contact', 'Let’s'],
            'appraisals' => ['/appraisals', 'Appraisal'],
            'terms' => ['/appraisals/terms', 'Terms'],
            'procedure' => ['/appraisals/procedure', 'Procedure'],
            'fees' => ['/appraisals/fees', 'Fee'],
        ];
    }

    #[DataProvider('pages')]
    public function test_pages_render_real_content(string $url, string $text): void
    {
        $this->get($url)
            ->assertOk()
            ->assertSee($text, false)
            ->assertDontSee('In migration')
            ->assertSee('<main id="main">', false)
            ->assertSee('class="site-footer"', false);
    }

    /** @return array<string, array{string}> */
    public static function slugs(): array
    {
        return array_map(fn ($s) => [$s], array_combine(
            ['regulatory', 'assaying', 'acquisition', 'auction', 'monetization'],
            ['regulatory', 'assaying', 'acquisition', 'auction', 'monetization'],
        ));
    }

    #[DataProvider('slugs')]
    public function test_service_pages_render_from_config(string $slug): void
    {
        $service = \App\Models\Service::where('slug', $slug)->firstOrFail()->toArray();

        $this->get("/services/$slug")
            ->assertOk()
            ->assertSee($service['title'])
            ->assertSee($service['alt'])
            ->assertSee('aria-current="page"', false);
    }

    public function test_database_holds_the_five_seeded_services(): void
    {
        $this->assertSame(
            ['regulatory', 'assaying', 'acquisition', 'auction', 'monetization'],
            \App\Models\Service::orderBy('sort_order')->pluck('slug')->all(),
        );
    }

    public function test_unknown_service_slug_is_a_real_404(): void
    {
        $this->get('/services/nope')->assertNotFound()->assertSee('Page', false);
        $this->get('/nope')->assertNotFound();
    }

    /** @return array<string, array{string, string}> */
    public static function legacy(): array
    {
        return [
            ['/about.php', '/about'],
            ['/services.php', '/services'],
            ['/contact.php', '/contact'],
            ['/antique-appraisals.php', '/appraisals'],
            ['/appraisal-terms.php', '/appraisals/terms'],
            ['/appraisal-procedure.php', '/appraisals/procedure'],
            ['/appraisal-fees.php', '/appraisals/fees'],
            ['/service-detail.php?service=auction', '/services/auction'],
        ];
    }

    #[DataProvider('legacy')]
    public function test_legacy_urls_redirect(string $old, string $new): void
    {
        $this->get($old)->assertRedirect($new)->assertStatus(302);
    }

    public function test_legacy_service_url_with_bad_or_missing_slug_is_404(): void
    {
        $this->get('/service-detail.php?service=bad')->assertNotFound();
        $this->get('/service-detail.php')->assertNotFound();
        $this->get('/service-detail.php?service[]=auction')->assertNotFound();
    }

    public function test_pages_have_no_legacy_php_links(): void
    {
        foreach (array_column(self::pages(), 0) as $url) {
            $html = $this->get($url)->getContent();
            $this->assertDoesNotMatchRegularExpression('~(?:href|src)="[^"]*\.php~', $html, $url);
        }
    }

    public function test_layout_sets_title_and_description(): void
    {
        $this->get('/about')
            ->assertSee('<title>About Wonder Antique Metals | A Connected Market Perspective</title>', false);
        $this->get('/')
            ->assertSee('<title>Wonder Antique Metals — Precious Metals &amp; Market Services</title>', false);
    }

    public function test_nav_links_resolve(): void
    {
        $html = $this->get('/')->getContent();
        preg_match_all('~href="(http://[^/"]+)?(/[^"#]*)"~', $html, $m);
        foreach (array_unique($m[2]) as $path) {
            if (str_starts_with($path, '/assets')) {
                continue;
            }
            $this->get($path)->assertOk();
        }
    }
}
