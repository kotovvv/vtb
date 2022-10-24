<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;

class VtbController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    private function getVTBToken()
    {
        $client_id = '616a9f0e28514925685a9a9fe5b8a7ea';
        $client_secret = 'c2a549efeff9d852c8ec2a6316161c02';
        $data = ["grant_type" => "client_credentials", "client_id" => $client_id, "client_secret" => $client_secret];
        $response = Http::asForm()->withHeaders([
            'Content-Type' => 'application/x-www-form-urlencoded'
        ])->post('https://passport.api.vtb.ru/passport/oauth2/token', $data);

        if (isset($response['access_token'])) return ['successful' => true, 'token' => $response['access_token']];

        return ['data' => $response->object(), 'successful' => false, 'status' => $response->error_description];
    }

    public function CheckInn($inn)
    {
        $status_token = $this->getVTBToken();
        $stepleads = ['leads' => [(object)['inn' => $inn, 'productCode' => 'Payments']]];
        if (isset($status_token['token']) && $status_token['successful'] == true) {
            try {
                // send lid in bank check duble
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $status_token['token'],
                    'Content-Type' => 'application/json'
                ])->post('https://epa.api.vtb.ru/openapi/smb/lecs/lead-impers/v1/check_leads', $stepleads);
            } catch (RequestException $e) {
                return response(['message' => $e, 'successful' => false]);
            }
            if ($response->status() == 500) {
                return response(['message' => 'Сервер не отвечает', 'successful' => false]);
            }
            if ($response->status() == 200) {
                $rclients = json_decode($response->body('data'))->leads;
                foreach ($rclients as $o_rclient) {

                    if ($o_rclient->responseCode == 'POSITIVE') {
                        return response(['message' => $o_rclient->responseCodeDescription, 'successful' => true]);
                    } else {
                        return response(['message' => $o_rclient->responseCodeDescription, 'successful' => true]);
                    }
                }
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
