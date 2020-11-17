<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use Response;
class ApiController extends Controller
{
    //
    protected $client;
    public function __construct() {
        $this->client = new Client( [
            'timeout' => 1000,
            'verify' => false,
            'base_uri' => "https://saigonairportplaza.com/wp-json/",
            'cookies' => true,
            'request.options' => [
                'proxy' => 'tcp://117.2.82.96:53988',
            ],
        ] );
    }
    public function ipnUrl(Request $request){
        $inputData = array();
        $returnData = array();
        $data = $request->all();
        foreach ($data as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }

        $vnp_SecureHash = $inputData['vnp_SecureHash'];
        unset($inputData['vnp_SecureHashType']);
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . $key . "=" . $value;
            } else {
                $hashData = $hashData . $key . "=" . $value;
                $i = 1;
            }
        }
        $vnp_HashSecret = "ZTCBTILLJNMNEQHOSXXDJIJQVCFPPMWO";
        $secureHash = hash('sha256', $vnp_HashSecret . $hashData);
        $vnp_Amount = $inputData['vnp_Amount'];
        $vnp_Amount = (int)$vnp_Amount / 100;
        $book = $this->client->post(
            'my/v1/booking',
            [
                'form_params' => [
                    'bookingId' => $inputData['vnp_TxnRef']
                ],
            ]
        );
        $bookData = json_decode($book->getBody() );
        //Log::info(print_r($bookData,true));
        //Log::info($bookData);

        $bookTotal = $this->client->post(
            'my/v1/bookingTotal',
            [
                'form_params' => [
                    'bookingId' => $inputData['vnp_TxnRef']
                ],
            ]
        );
        $bookTotalData = json_decode($bookTotal->getBody() );
        try {
            // checksum
            if ($secureHash == $vnp_SecureHash) {
                // check OrderId
                if ($bookData->data->id != NULL && $bookData->data->id > 0) {
                    // check amount
                    if($bookTotalData->data != null && $bookTotalData->data == $vnp_Amount ){
                        // check Status
                        if (isset($bookData->data->post->post_status) && $bookData->data->post->post_status === 'hb-pending') {

                            if ($inputData['vnp_ResponseCode'] == '00') {
                                $Status = 1; // Payment status success
                                // Here code update payment status success into your database
                                // ex:
                                // $update = "UPDATE `orders` SET `Status`='".sql_escape($Status)."' WHERE `OrderId`=" . sql_escape($Id);
                                $returnData['RspCode'] = '00';
                                $returnData['Message'] = 'Confirm Success';
                                $bookStatus = $this->client->post(
                                    'my/v1/updateStatus',
                                    [
                                        'form_params' => [
                                            'bookingId' => $inputData['vnp_TxnRef'],
                                            'status' => "hb-completed",
                                        ],
                                    ]
                                );
                              //  Log::info(print_r($bookStatus,true));
                            } else {
                                $bookStatus = $this->client->post(
                                    'my/v1/updateStatus',
                                    [
                                        'form_params' => [
                                            'bookingId' => $inputData['vnp_TxnRef'],
                                            'status' => "hb-cancelled",
                                        ],
                                    ]
                                );
                               // Log::info(print_r($bookStatus,true));
                                $Status = 2; // Payment status fail
                                // Here code update payment status fail into your database
                                // ex:
                                // $update = "UPDATE `orders` SET `Status`='".sql_escape($Status)."' WHERE `OrderId`=" . sql_escape($Id);
                                $returnData['RspCode'] = '00';
                                $returnData['Message'] = 'Confirm Success';
                            }

                        } else {
                            $returnData['RspCode'] = '02';
                            $returnData['Message'] = 'Order already confirmed';
                        }
                    }
                    else
                    {
                        $returnData['RspCode'] = '04';
                        $returnData['Message'] = 'Invalid Amount';
                    }
                } else {
                    $returnData['RspCode'] = '01';
                    $returnData['Message'] = 'Order not found';
                }
            } else {
                $returnData['RspCode'] = '97';
                $returnData['Message'] = 'Chu ky khong hop le';
            }
        } catch (\Exception $e) {
            $returnData['RspCode'] = '99';
            $returnData['Message'] = 'Unknow error';
        }
        Log::info(print_r($returnData,true));
        return Response::json($returnData);
    }
}
