<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;

class BooksController extends Controller
{
    /**
     * Display a listing of books
    */
    public function index(): JsonResponse
    {
        $client = new Client(['base_uri' => 'https://anapioficeandfire.com']);

        try {
            $response = $client->request('GET', '/api/books');

            $books = json_decode($response->getBody()->getContents(),true);

            foreach ($books as &$book){
                unset($book['characters'], $book['povCharacters']);

                $book['comment_count'] = Comment::where("book_isbn", $book['isbn'])->count();
            }

            array_multisort(array_column($books, 'released'), SORT_ASC, $books);

            return response()->json([
                'status' => 'success',
                'data' => $books
            ]);

        } catch (GuzzleException $e) {
            return response()->json([
                'status' => "failed",
                'message' => 'An error occurred while fetching books',
                'trace' => $e->getMessage()
            ],500);
        }
    }

    //
}
