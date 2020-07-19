<?php

namespace App\Http\Controllers;

use App\Mail\OrderShipped;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    /**
     * Ship the given order.
     *
     * @param  Request  $request
     * @param  int  $orderId
     * @return Response
     */
    public function ship(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);

        // Ship order...

//        Mail::to($request->user())->send(new OrderShipped($order));
        $toStr = env('EMAILS_TO', '');
        $to = (strlen($toStr)) ? explode(',', $toStr) : [];

        $ccStr = env('EMAILS_CC', '');
        $cc = (strlen($ccStr)) ? explode(',', $ccStr) : [];

        $bccStr = env('EMAILS_BCC', '');
        $bcc = (strlen($bccStr)) ? explode(',', $bccStr) : [];

        Mail::to($to)
            ->cc($cc)
            ->bcc($bcc)
            ->send(new OrderShipped($order, $request->all()));

        return $request->all();
    }
}
