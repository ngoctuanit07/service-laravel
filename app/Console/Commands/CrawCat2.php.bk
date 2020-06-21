<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\CrawCat as CrawCategory;
use App\ConfigCrawCat;
use Symfony\Component\DomCrawler\Crawler;
use GuzzleHttp\Client;
use DB;
use App\StorageUrl;

class CrawCat extends Command {
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = 'craw:cat';
    private $client;
    private $title;
    private $content;
    private $image;
    /**
    * The console command description.
    *
    * @var string
    */
    protected $description = 'Craw Data From category';

    /**
    * Create a new command instance.
    */

    public function __construct() {
        parent::__construct();
        $this->client = new Client( [
            'timeout' => 1000,
            'verify' => false,
            'request.options' => [
                'proxy' => 'tcp://222.252.12.76:1080',
            ],
        ] );
    }

    /**
    * Execute the console command.
    *
    * @return mixed
    */

    public function handle() {
        $configCats = ConfigCrawCat::orderBy( 'id', 'DESC' )->get();
        foreach ( $configCats as $configcat ) {
            if ( $configcat->status == 1 ) {
                $title = $configcat->title;
                $content = $configcat->content;
                $imageUrl = $configcat->featured_image;
                $contentFull = $configcat->contentfull;
                $url = $configcat->cat_url;
                $continuity = $configcat->continuity;
                $configId = ( int ) $configcat->id;

                $sitemap = $configcat->sitemap;
                if ( $configcat->sitemap && isset( $configcat->sitemap ) ) {
                    $this->crawDataFromSitemap( $sitemap, $configId, $url, $configcat->user_id );
                } else {
                    $this->crawCat( $url, $contentFull, $title, $content, $imageUrl, $configcat->user_id, $continuity );
                }
            }
        }

        // $test = $this->getCrawlerContent12( 'https://hocwordpress.vn/render-tin-tuc-moi-cua-homepage-tren-gatsby' );
    }

    protected function crawDataFromSitemap( $url, $sitemap, $configId, $urserId ) {
        $contents = $this->curlGetPageXml( $sitemap );
        dd( $contents );
        foreach ( $contents as $content ) {
            $contentUrl = strip_tags( $content );
            if ( $contentUrl == $url ) {
                break;
            } else {
                StorageUrl::create( ['url' => $contentUrl, 'status' => 1, 'user_id' => $urserId, 'config_id' => $configId] );
            }
        }
        DB::table( 'configcrawcat' )
        ->where( 'id', $configId )
        ->update( ['status' => 0] );
    }

    protected function crawCat( $url, $contentFull, $title, $contentCraw, $imageUrl, $userId, $continuity ) {
        $catUrls = $this->getUrls( $url );
        $count = count( $catUrls );
        $count2 = 0;
        $count3 = 0;
        foreach ( $catUrls as $catUrl ) {
            $resultDatas = $this->getCrawlerContent( $catUrl, $contentFull, $title, $contentCraw, $imageUrl );
            if ( $count3 == 3 ) {
                sleep( 120 );
            }
            if ( $resultDatas == false ) {
                return false;
            } else {
                foreach ( $resultDatas as $data ) {
                    if ( isset( $data['title'] ) && $data['title'] && isset( $data['content'] ) && $data['content'] && isset( $data['featured_image'] ) && $data['featured_image'] ) {
                        $crawDataCheck = DB::table( 'crawcat' )->where( 'title', $data['title'] )->first();
                        if ( $crawDataCheck && isset( $crawDataCheck ) ) {
                            break;
                        } else {
                            CrawCategory::create( ['title' => $data['title'], 'content' => $data['content'], 'featured_image' => $data['featured_image'], 'user_id' => $userId, 'cat_url' => $url] );
                            ++$count2;
                        }
                    }
                }
            }

            ++$count3;
        }
        if ( $count == $count2 ) {
            if ( $continuity != 0 ) {
                DB::table( 'configcrawcat' )
                ->where( 'user_id', $userId )
                ->update( ['status' => 1] );
            } else {
                DB::table( 'configcrawcat' )
                ->where( 'user_id', $userId )
                ->update( ['status' => 0] );
            }
        }
    }

    protected function check( $proxy = null ) {
        $proxy = explode( ':', $proxy );
        $host = $proxy[0];
        $port = $proxy[1];
        $waitTimeoutInSeconds = 30;
        if ( $fp = @fsockopen( $host, $port, $errCode, $errStr, $waitTimeoutInSeconds ) ) {
            return true;
        } else {
            return false;
        }
        fclose( $fp );
    }

    protected function getRandomUserAgent() {
        $userAgents = array(
            'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-GB; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6',
            'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)',
            'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.1.4322; .NET CLR 2.0.50727; .NET CLR 3.0.04506.30)',
            'Opera/9.20 (Windows NT 6.0; U; en)',
            'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; en) Opera 8.50',
            'Mozilla/4.0 (compatible; MSIE 6.0; MSIE 5.5; Windows NT 5.1) Opera 7.02 [en]',
            'Mozilla/5.0 (Macintosh; U; PPC Mac OS X Mach-O; fr; rv:1.7) Gecko/20040624 Firefox/0.9',
            'Mozilla/5.0 (Macintosh; U; PPC Mac OS X; en) AppleWebKit/48 (like Gecko) Safari/48',
        );
        $random = rand( 0, count( $userAgents ) - 1 );

        return $userAgents[$random];
    }

    protected function curlGetPageXml( $url = '' ) {
        $proxyDB = DB::table( 'proxy' )->where( 'status', 1 )->inRandomOrder()->first();
        $checkProxy = $this->check( $proxyDB->url );
        $proxy = '';
        if ( $checkProxy == true ) {
            $proxy = $proxyDB->url;
        }

        error_reporting( E_ALL );

        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $url );
        // URL for CURL call
        curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 120 );
        curl_setopt( $ch, CURLOPT_TIMEOUT, 120 );
        curl_setopt( $ch, CURLOPT_USERAGENT, $this->getRandomUserAgent() );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );

        // PROXY details with port
        //curl_setopt( $ch, CURLOPT_PROXYUSERPWD, $proxyauth );
        // Use if proxy have username and password
        if ( $proxyDB->type === 'SOCKS4' ) {
            $customProxy = 'sockets4://'.$proxy;
            curl_setopt( $ch, CURLOPT_PROXY, $customProxy );
            curl_setopt( $ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS4 );
            // If expected to call with specific PROXY type
        } else {
            curl_setopt( $ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5 );
            // If expected to call with specific PROXY type
        }
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, false );
        //curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1 );
        // If url has redirects then go to the final redirected URL.
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        // Do not outputting it out directly on screen.
        curl_setopt( $ch, CURLOPT_HEADER, 1 );
        // curl_setopt( $ch, CURLOPT_HTTPHEADER, [
        //     'Content-type: application/xml'
        // ] );
        // If you want Header information of response else make 0
        $curl_scraped_page = curl_exec( $ch );
        //return $return;
        if ( curl_errno( $ch ) ) {
            return curl_error( $ch );
        }
        curl_close( $ch );
        $links = array();
        $count = preg_match_all( '@<loc>(.+?)<\/loc>@', $curl_scraped_page, $matches );
        for ( $i = 0; $i < $count; ++$i ) {
            $links[] = $matches[0][$i];
        }

        return $links;
    }

    protected function curlGetPage( $url = '' ) {
        $proxyDB = DB::table( 'proxy' )->where( 'status', 1 )->inRandomOrder()->first();
        $checkProxy = $this->check( $proxyDB->url );
        $proxy = '';
        if ( $checkProxy == true ) {
            $proxy = $proxyDB->url;
        }

        error_reporting( E_ALL );
        // $url = 'https://www.quocbuugroup.com/thiet-ke-bo-nhan-dien-thuong-hieu.html';
        // $proxy = '127.0.0.1:8888';
        // $proxyauth = 'user:password';

        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $url );
        // URL for CURL call
        curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 500 );
        curl_setopt( $ch, CURLOPT_TIMEOUT, 500 );
        curl_setopt( $ch, CURLOPT_USERAGENT, $this->getRandomUserAgent() );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
        curl_setopt( $ch, CURLOPT_PROXY, $proxy );
        // PROXY details with port
        //curl_setopt( $ch, CURLOPT_PROXYUSERPWD, $proxyauth );
        // Use if proxy have username and password
        if ( $proxyDB->type === 'SOCKS4' ) {
            curl_setopt( $ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS4 );
            // If expected to call with specific PROXY type
        } else {
            curl_setopt( $ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5 );
            // If expected to call with specific PROXY type
        }
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, false );
        //curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1 );
        // If url has redirects then go to the final redirected URL.
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 0 );
        // Do not outputting it out directly on screen.
        curl_setopt( $ch, CURLOPT_HEADER, 1 );
        // If you want Header information of response else make 0
        $curl_scraped_page = curl_exec( $ch );
        //return $return;
        if ( curl_errno( $ch ) ) {
            return curl_error( $ch );
        }
        curl_close( $ch );

        return json_decode( $curl_scraped_page, true );
    }

    protected function getCrawlerContent( $url, $contentFull, $title, $contentCraw, $imageUrl ) {
        try {
            $data = '';
            $response = $this->curlGetPage( $url );
            //$this->client->get( $url );
            // URL, where you want to fetch the content
            // get content and pass to the crawler
            // $content = $response->getBody()->getContents();
            // dd( $content );
            if ( $response === 'Failed to receive SOCKS4 connect request ack.' || $response === 'Failed to receive SOCKS5 connect request ack.' ) {
                return false;
            } else {
                $crawler = new Crawler( $response );
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
            }

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

    public function getUrls( $url = '' ) {
        $urls = [];

        if ( $url != '' ) {
            $baseUrl = $url;
            $prefix = 'https';
            if ( strpos( $baseUrl, 'ttps://' ) === false ) {
                $prefix = 'http';
            }
            $client = new Client();
            $response = $client->request( 'GET', $url );
            $html = $response->getBody();
            //Getting the exact url without http or https
            $url = str_replace( 'http://www.', '', $url );
            $url = str_replace( 'https://www.', '', $url );
            $url = str_replace( 'http://', '', $url );
            $url = str_replace( 'https://', '', $url );
            //Parsing the url for getting host information
            $parse = parse_url( 'https://'.$url );
            //Parsing the html of the base url
            $dom = new \DOMDocument();
            @$dom->loadHTML( $html );
            // grab all the on the page
            $xpath = new \DOMXPath( $dom );
            //finding the a tag
            $hrefs = $xpath->evaluate( '/html/body//a' );
            //Loop to display all the links
            $length = $hrefs->length;
            //Converting URLs to add the www prefix to host to a common array
            $baseUrl = str_replace( 'http://'.$parse['host'], 'http://www.'.$parse['host'], $baseUrl );
            $baseUrl = str_replace( 'https://'.$parse['host'], 'https://www.'.$parse['host'], $baseUrl );
            $urls = [$baseUrl];
            $allUrls = [$baseUrl];
            for ( $i = 0; $i < $length; ++$i ) {
                $href = $hrefs->item( $i );
                $url = $href->getAttribute( 'href' );
                $url = str_replace( 'http://'.$parse['host'], 'http://www.'.$parse['host'], $url );
                $url = str_replace( 'https://'.$parse['host'], 'https://www.'.$parse['host'], $url );
                //Replacing the / at the end of any url if present
                if ( substr( $url, -1, 1 ) == '/' ) {
                    $url = substr_replace( $url, '', -1 );
                }
                array_push( $allUrls, $url );
            }

            //Looping for filtering the URLs into a distinct array
            foreach ( $allUrls as $url ) {
                //Limiting the number of urls on the site
                if ( count( $urls ) >= 300 ) {
                    break;
                }
                //Filter the null links and images
                if ( strpos( $url, '#' ) === false ) {
                    //Filtering the links with host
                    if ( strpos( $url, 'https://'.$parse['host'] ) !== false || strpos( $url, 'https://www.'.$parse['host'] ) !== false ) {
                        //Replacing the / at the end of any url if present
                        if ( substr( $url, -1, 1 ) == '/' ) {
                            $url = substr_replace( $url, '', -1 );
                        }
                        //Checking if the link is already preset in the final array
                        $urlSuffix = str_replace( 'http://www.', '', $url );
                        $urlSuffix = str_replace( 'https://www.', '', $urlSuffix );
                        $urlSuffix = str_replace( 'http://', '', $urlSuffix );
                        $urlSuffix = str_replace( 'https://', '', $urlSuffix );

                        if ( $urlSuffix != $parse['host'] ) {
                            array_push( $urls, $url );
                        }
                    }
                    //Filtering the links without host
                    if ( strpos( $url, $parse['host'] ) === false ) {
                        if ( substr( $url, 0, 1 ) == '/' ) {
                            //Replacing the / at the end of any url if present
                            if ( substr( $url, -1, 1 ) == '/' ) {
                                $url = substr_replace( $url, '', -1 );
                            }
                            $newUrl = 'http://www.'.$parse['host'].$url;
                            $secondUrl = 'https://www.'.$parse['host'].$url;
                            if ( $url != $parse['host'] ) {
                                //Checking if the link is already preset in the final array and the common array
                                if ( !in_array( $secondUrl, $urls ) && !in_array( $secondUrl, $allUrls ) && !in_array( $newUrl, $allUrls ) ) {
                                    if ( $prefix == 'https' ) {
                                        $newUrl = $secondUrl;
                                    }
                                    array_push( $urls, $newUrl );
                                }
                            }
                        }
                    }
                }
            }
        }

        return $urls;
    }
}
