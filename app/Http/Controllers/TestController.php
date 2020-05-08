<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleXMLElement;
use Illuminate\Support\Str;
use Symfony\Component\DomCrawler\Crawler;
use GuzzleHttp\Client;
use Exception;

class TestController extends Controller {
    //
    private $client;
    private $title;
    private $content;
    private $image;

    public function __construct() {
        $username = 'admin';
        $password = 'Y7V(Ias0QtMNOGSvemhm34*z';
        $this->client = new Client( [
            'timeout' => 10,
            'verify' => false,
            'base_uri' => 'https://johnnguyenn.com/wp-json/wp/v2/',
            'headers' => [
                'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczpcL1wvam9obm5ndXllbm4uY29tIiwiaWF0IjoxNTg4ODYwNjY2LCJuYmYiOjE1ODg4NjA2NjYsImV4cCI6MTU4OTQ2NTQ2NiwiZGF0YSI6eyJ1c2VyIjp7ImlkIjoiMSJ9fX0._QGEP6bMaC1u43xJaSw5LCbmLdKoXaKNh_aXorCTvdg',
                'Accept' => 'application/json',
                'Content-type' => 'application/json',
                'Content-Disposition' => 'attachment',
            ]
        ] );
    }

    public function index() {
        // $xml = simplexml_load_file( 'https://hocwordpress.vn/post-sitemap.xml' );
        // echo '<ul>';
        // foreach ( $xml as $name ) {
        //     //    dd( $name->loc );
        //     if ( $name->loc == 'https://hocwordpress.vn/' ) {
        //         continue;
        //     } else {
        //         echo '<li>'.$name->loc.'</li>';
        //     }

        // }
        // echo '</ul>';
        // $file = file_get_contents( 'https://hocwordpress.vn/wp-content/uploads/2020/03/cai-dat-wordpress-localhost-01.jpg' );
        // $url = 'http://wordpressdev.johnnguyenn.com/wp-json/wp/v2/media';
        // $ch = curl_init();
        // $username = 'admin';
        // $password = '70uY$r?`)F:^Oz~4`,T';
        // curl_setopt( $ch, CURLOPT_URL, $url );
        // curl_setopt( $ch, CURLOPT_POST, 1 );
        // curl_setopt( $ch, CURLOPT_POSTFIELDS, $file );
        // curl_setopt( $ch, CURLOPT_HTTPHEADER, [
        //     'Content-Disposition: form-data; filename="media-file.jpg"',
        //     'Authorization: Bearer:eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC93b3JkcHJlc3NkZXYuam9obm5ndXllbm4uY29tIiwiaWF0IjoxNTg4ODM4NTA1LCJuYmYiOjE1ODg4Mzg1MDUsImV4cCI6MTU4OTQ0MzMwNSwiZGF0YSI6eyJ1c2VyIjp7ImlkIjoiMSJ9fX0.WkWyKPvG5a8j1oP8zSDHnyJ8vqS89ZID2V9_ojyk2QQ',
        // ] );
        // $result = curl_exec( $ch );
        // curl_close( $ch );
        // var_dump( json_decode( $result ) );
        $imageOnMedia =  $this->client->post(
            'media',
            [
                'multipart' => [
                    [
                        'name' => 'file',
                        'contents' => file_get_contents( 'https://hocwordpress.vn/wp-content/uploads/2020/03/menu-wordpress-2-1.jpg' ),
                        'filename' => Str::random(40).'.jpg',
                    ],
                ],
                'query' => [
                    'status' => 'publish',
                    'title' => 'cai-dat-wordpress-localhost-01',
                    'comment_status' => 'closed',
                    'ping_status' => 'closed',
                    'alt_text' => 'cai-dat-wordpress-localhost-01',
                    'description' => '',
                    'caption' => '',
                ],
            ]
        );
        $media = json_decode( $imageOnMedia->getBody(), true );
        //dd($media['id']);
        $post = $this->client->post(
            'posts',
            [
                'multipart' => [
                    [
                        'name' => 'title',
                        'contents' => 'Gạo Yêu Mẹ2',
                    ],
                    [
                        'name' => 'content',
                        'contents' => 'Gạo Yêu Mẹ'
                    ],
                    [
                        'name' => 'featured_media',
                        'contents' => $media['id']
                    ],
                ],
                'query' => [
                    'status' => 'publish',
                    'categories' => 2
                ]
            ] );

            dd( $post );
    }
}
