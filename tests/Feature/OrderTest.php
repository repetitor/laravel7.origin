<?php

namespace Tests\Feature;

use App\Mail\OrderShipped;
use App\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Tests\TestCase;

class OrderTest extends TestCase
{
    protected static $isSetUpOnce = false;

    private static $request;

    public function setUp(): void
    {
        parent::setUp();
        Mail::fake();

        if (!static::$isSetUpOnce) {
//            Artisan::call('migrate:refresh');
//            Artisan::call('db:seed', ['--class' => 'OrderSeeder']);

            $json='{
                "parent1": "value1",
                "parent2": "value2",
                "parent3": {
                    "child1": "value child1",
                    "child2": "value child2",
                    "child3": "value child3"
                },
                "parent4": "value4"
            }';
            static::$request = json_decode($json, true);

            static::$isSetUpOnce = true;
        }
    }

//    public function tearDown(): void
//    {
//        parent::refresh();
//    }

    public function test_success()
    {
        $response = $this->postJson('/api/order-mail/1', static::$request);

        $response->assertStatus(200);

        // Assert a mailable was sent once...
        Mail::assertSent(OrderShipped::class, 1);

        Mail::assertSent(OrderShipped::class);

        Mail::assertSent(OrderShipped::class, function ($mail) {
            return $mail->hasTo('viktar202@mail.ru') && $mail->hasBcc('viktar202@yandex.ru');
        });

        $bccStr = env('EMAILS_BCC', '');
        $bcc = (strlen($bccStr)) ? explode(',', $bccStr) : [];

        if(count($bcc)) {
            Mail::assertSent(OrderShipped::class, function ($mail) use ($bcc) {
                return $mail->hasTo('viktar202@mail.ru') && $mail->hasBcc($bcc[0]);
            });
        }

        $this->assertTrue(View::exists('emails.orders.shipped'));

        $order = Order::find(1);
        Mail::assertSent(OrderShipped::class, function ($mail) use ($order) {
            $filled = $mail->build();

            return $filled->subject === 'test name subject' &&
                $filled->order->name == $order->name;
        });
    }

    public function test_success_without_request()
    {
        $response = $this->postJson('/api/order-mail/1');

        $response->assertStatus(200);
        Mail::assertSent(OrderShipped::class, 1);
    }

    public function test_success_error_unexisted_order()
    {
        $lastOrder = Order::all()->last();
        $unexistedId = $lastOrder->id + 1;
        $response = $this->postJson('/api/order-mail/' . $unexistedId, static::$request);

        $response->assertStatus(404);
        Mail::assertNothingSent();
    }
}
