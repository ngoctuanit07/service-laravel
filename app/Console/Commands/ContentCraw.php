<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Craw;
use Symfony\Component\DomCrawler\Crawler;
use GuzzleHttp\Client;

class ContentCraw extends Command {
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    private $client;
    private $title;
    private $content;
    private $image;
    protected $signature = 'content:craw';

    /**
    * The console command description.
    *
    * @var string
    */
    protected $description = 'Craw content from sitemap';

    /**
    * Create a new command instance.
    *
    * @return void
    */

    public function __construct() {
        parent::__construct();
        $this->client = new Client( [
            'timeout' => 1000,
            'verify' => false,
            'proxy' => 'http://114.106.151.212:38801/'
        ] );
    }

    /**
    * Execute the console command.
    *
    * @return mixed
    */

    public function handle() {
        //
        $xml = simplexml_load_file( 'https://monngon365.net/post-sitemap1.xml' );
        foreach ( $xml as $name ) {
            if ( $name->loc == 'https://monngon365.net/' ) {
                continue;
            } else {
                $parentContent = '.td-ss-main-content';
                $title = '.entry-title';
                $content = '.td-post-content';
                $featured_image = '.td-post-content p img';
                // $parentContent = '.content-box-news';
                // $title = '.single-title';
                // $content = '.post-content';
                // $featured_image = '.post-content p img';
                // $parentContent = '.type-post';
                // $title = '.entry-title';
                // $content = '.entry-content';
                // $featured_image = '.entry-content p img';
                // dd( ( string ) $name->loc );
                $resultData = $this->getCrawlerContent( ( string ) $name->loc, $parentContent, $title, $content, $featured_image );
                // dd( $resultData );
                //   dd( array_filter( $resultData ) );
                foreach ( $resultData as $key => $data ) {
                    if ( isset( $data['title'] ) && $data['title'] && isset( $data['content'] ) && $data['content']  && isset( $data['featured_image'] ) && $data['featured_image'] ) {
                        Craw::create( ['title' => $data['title'], 'content' => $data['content'], 'featured_image' => $data['featured_image'],  'cat_id' => 2] );
                        sleep( 60 );
                    }
                }

            }

        }
    }

    protected function getCrawlerContent( $url, $contentFull, $title, $contentCraw, $imageUrl ) {
        try {
            $response = $this->client->get( $url );
            // URL, where you want to fetch the content
            // get content and pass to the crawler
            $content = $response->getBody()->getContents();
            $crawler = new Crawler( $content );
            $this->title = $title;
            $this->content = $contentCraw;
            $this->image = $imageUrl;
            $_this = $this;
            $data = $crawler->filter( $contentFull )
            ->each (

                function ( Crawler $node, $i ) use ( $_this ) {
                    return $_this->getNodeContent( $node, $_this );
                }
            );
            return $data;

        } catch ( Exception $e ) {
            echo $e->getMessage();
        }
    }
    /**
    * Check is content available.
    */

    private function hasContent( $node ) {
        return $node->count() > 0 ? true : false;
    }

    /**
    * Get node values.
    *
    * @filter function required the identifires, which we want to filter from the content.
    */

    private function getNodeContent( $node, $_this ) {
        $array = [
            'title' => $this->hasContent( $node->filter( $_this->title ) ) != false ? $node->filter( $_this->title )->text() : '',
            'content' => $this->hasContent( $node->filter( $_this->content ) ) != false ? $node->filter( $_this->content )->html() : '',
            'featured_image' => $this->hasContent( $node->filter( $_this->image ) ) != false ? $node->filter( $_this->image )->eq( 0 )->attr( 'src' ) : '',
        ];

        return $array;
    }

}
