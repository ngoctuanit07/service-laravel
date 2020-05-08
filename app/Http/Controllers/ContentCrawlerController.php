<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;
use GuzzleHttp\Client;
use Exception;

class ContentCrawlerController extends Controller
{
    private $client;
    private $title;
    private $content;
    private $image;

    public function __construct()
    {
        $this->client = new Client([
            'timeout' => 10,
            'verify' => false,
        ]);
    }

    /**
     * Content Crawler.
     */
    public function getCrawlerContent(Request $request)
    {
        //dd($obj->url);
        try {
            $arrJson = json_decode($request->getContent(), true);

            $obj = (object) $arrJson;
            $response = $this->client->get($obj->url); // URL, where you want to fetch the content
            // get content and pass to the crawler
            $content = $response->getBody()->getContents();
            $crawler = new Crawler($content);
            $this->title = $obj->title;
            $this->content = $obj->content;
            $this->image = $obj->featured_image;
            $_this = $this;

            $data = $crawler->filter($obj->contentfull)
                            ->each(function (Crawler $node, $i) use ($_this) {
                                return $_this->getNodeContent($node, $_this);
                            }
                        );
            dd($data);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Check is content available.
     */
    private function hasContent($node)
    {
        return $node->count() > 0 ? true : false;
    }

    /**
     * Get node values.
     *
     * @filter function required the identifires, which we want to filter from the content.
     */
    private function getNodeContent($node, $_this)
    {
        $array = [
            'title' => $this->hasContent($node->filter($_this->title)) != false ? $node->filter($_this->title)->text() : '',
            'content' => $this->hasContent($node->filter($_this->content)) != false ? $node->filter($_this->content)->html() : '',
         'featured_image' => $this->hasContent($node->filter($_this->image)) != false ? $node->filter($_this->image)->eq(0)->attr('src') : '',
        ];

        return $array;
    }
}
