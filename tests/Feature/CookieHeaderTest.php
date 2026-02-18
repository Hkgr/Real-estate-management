<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class CookieHeaderTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // أنشئ الراوت فقط إذا لم يكن موجوداً مسبقاً
        if (! Route::has('__cookie_test')) {
            Route::middleware('web')
                ->get('/__cookie_test', function () {
                    return response('ok')->cookie('cookie_test', '1', 60);
                })
                ->name('__cookie_test');
        }
    }

    public function test_cookie_is_sent_on_cookie_test_route(): void
    {
        $response = $this->get('/__cookie_test');

        $response->assertOk();

        // التحقق الصحيح من الكوكي (بدون الاعتماد على assertHeader('Set-Cookie'))
        $response->assertCookie('cookie_test');

        // تأكيد إضافي: الكوكي موجودة ضمن CookieBag
        $cookies = $response->headers->getCookies();

        $this->assertNotEmpty($cookies, 'No cookies were attached to the response.');

        $this->assertTrue(
            collect($cookies)->contains(fn ($c) => $c->getName() === 'cookie_test'),
            'cookie_test cookie not found in the response cookies bag.'
        );
    }
}
