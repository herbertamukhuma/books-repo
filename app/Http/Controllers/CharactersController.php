<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CharactersController extends Controller
{
    /**
     * Display a listing of characters
     */
    public function query(Request $request){

        $order_by = $request->get("order_by");
        $order_direction = $request->get("order_direction");
        $gender = $request->get("gender");

        if($order_by === null){
            return response([
                'status' => 'failed',
                'message' => 'Kindly provide order_by parameter'
            ], 500);
        }

        if($order_direction === null){
            return response([
                'status' => 'failed',
                'message' => 'Kindly provide order_direction parameter'
            ], 500);
        }

        if(!in_array($order_by,['name','gender','age'])){
            return response([
                'status' => 'failed',
                'message' => 'Invalid value for order by. Kindly use one of the following, name, gender or age'
            ], 500);
        }

        if(!in_array(strtoupper($order_direction),['ASC','DESC'])){
            return response([
                'status' => 'failed',
                'message' => 'Invalid value for order direction. Kindly use one of the following, ASC, or DESC'
            ], 500);
        }else{
            $order_direction = strtoupper($order_direction) == 'ASC' ? SORT_ASC : SORT_DESC;
        }

        $client = new Client(['base_uri' => 'https://anapioficeandfire.com']);

        try {
            $response = $client->request('GET', '/api/characters');

            $characters = json_decode($response->getBody()->getContents(),true);

            if($gender !== null){
                $characters = array_filter($characters, function ($character) use($gender){
                    return strtoupper($character['gender']) === strtoupper($gender);
                });
            }

            if($order_by !== 'age'){
                // date of birth is not provided when fetching all characters
                array_multisort(array_column($characters, $order_by), $order_direction, $characters);
            }

            return response()->json([
                'status' => 'success',
                'data' => $characters,
                'meta' => [
                    'count' => count($characters),
                    // could not calculate age since the external API is not reliable in returning date of birth
                    // or date of death
                    'total_age' => null,
                ]
            ]);

        } catch (GuzzleException $e) {
            return response()->json([
                'status' => "failed",
                'message' => 'An error occurred while fetching characters',
                'trace' => $e->getMessage()
            ],500);
        }

    }
}
