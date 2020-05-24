<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use DB;

class TestController extends Controller
{
    private $client;
    private $title;
    private $content;
    private $image;

    public function __construct()
    {
        $username = 'admin';
        $password = 'Y7V(Ias0QtMNOGSvemhm34*z';
        $this->client = new Client([
            'timeout' => 10,
            'verify' => false,
            'base_uri' => 'https://johnnguyenn.com/wp-json/wp/v2/',
            'headers' => [
                'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczpcL1wvam9obm5ndXllbm4uY29tIiwiaWF0IjoxNTg4ODYwNjY2LCJuYmYiOjE1ODg4NjA2NjYsImV4cCI6MTU4OTQ2NTQ2NiwiZGF0YSI6eyJ1c2VyIjp7ImlkIjoiMSJ9fX0._QGEP6bMaC1u43xJaSw5LCbmLdKoXaKNh_aXorCTvdg',
                'Accept' => 'application/json',
                'Content-type' => 'application/json',
                'Content-Disposition' => 'attachment',
            ],
        ]);
    }

    public function index()
    {
        // $check = $this->curlGetPage('https://www.quocbuugroup.com/sitemap.xml');
        // if ($check == 0) {
        //     $proxyDB = DB::table('proxy')->where('status', 1)->inRandomOrder()->first();
        //     $checkProxy = $this->check($proxyDB->url);
        //     $proxy = '';
        //     if ($checkProxy == true) {
        //         $proxy = $proxyDB->url;
        //           $this->curlGetPage($proxy);
        //     }
        //     return;

        // }
        // $urls = $this->getUrls('https://hocwordpress.vn/lap-trinh-theme');
        // foreach ($urls as $url) {
        //     echo $url.'<br/>';
        // }

        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, 'http://dynupdate.no-ip.com/ip.php');
        // curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        // curl_setopt($ch, CURLOPT_USERAGENT, $this->getRandomUserAgent());
        // curl_setopt($ch, CURLOPT_PROXY, $proxy);
        // if ($proxyDB->type === 'SOCKS4') {
        //     curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS4);
        // } else {
        //     curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
        // }

        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_FAILONERROR, true);
        // curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        // $result = curl_exec($ch);
        // //print curl_errno ($ch);
        // echo $result;
        // curl_close($ch);
        // $ckfile = tempnam ("/tmp", 'cookiename');
//         $process = curl_init('https://johnnguyenn.com/wp-json/wp/v2/posts');
//         $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczpcL1wvam9obm5ndXllbm4uY29tIiwiaWF0IjoxNTg5OTU1MDM5LCJuYmYiOjE1ODk5NTUwMzksImV4cCI6MTU5MDU1OTgzOSwiZGF0YSI6eyJ1c2VyIjp7ImlkIjoiMSJ9fX0.J6kDfpVN51nnDpcpoubf4JJtOlutXuE-LAvYCfbYq4I';
//         $media = $this->uploadFile($token,"https://i.pinimg.com/originals/d0/d5/bd/d0d5bdb27664dbde7513d37d2b9f2f79.jpg");
//        // dd(json_decode($media, true));
//         $resultMedia = json_decode($media, true);
//        // create an array of data to use, this is basic - see other examples for more complex inserts
//         $data = array('slug' => 'rest_insert', 'title' => 'REST API insert 13', 'content' => 'The content of our stuff', 'excerpt' => 'smaller','featured_media' => $resultMedia['id']);
//         $data_string = json_encode($data);
//         // create the options starting with basic authentication
//         // curl_setopt($process, CURLOPT_USERPWD, $username.':'.$password);
//         curl_setopt($process, CURLOPT_TIMEOUT, 60);
//         curl_setopt($process, CURLOPT_POST, 1);
//         // make sure we are POSTing
//         curl_setopt($process, CURLOPT_USERAGENT, $this->getRandomUserAgent());
//         curl_setopt($process, CURLOPT_CUSTOMREQUEST, 'POST');
//         // this is the data to insert to create the post
//         curl_setopt($process, CURLOPT_POSTFIELDS, $data_string);
//         // allow us to use the returned data from the request
//         curl_setopt($process, CURLOPT_RETURNTRANSFER, true);
//         // we are sending json
//         curl_setopt($process, CURLOPT_HTTPHEADER, array(
//     'Content-Type: application/json',
//     'Content-Length: '.strlen($data_string),
//       'Authorization: Bearer '.$token,
//        'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
//                 'Accept-Encoding: gzip, deflate, br',
//                 'Content-Disposition:attachment',
        // ));
//         curl_setopt($process, CURLOPT_PROXY, $proxy);
//         $cookieFile = 'cookies.txt';
//         if (!file_exists($cookieFile)) {
//             $fh = fopen($cookieFile, 'w');
//             fwrite($fh, '');
//             fclose($fh);
//         }
//         curl_setopt($process, CURLOPT_COOKIEFILE, $cookieFile);
//         if ($proxyDB->type === 'SOCKS4') {
//             curl_setopt($process, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS4);
//         } else {
//             curl_setopt($process, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
//         }

//         // process the request
//         $return = curl_exec($process);
//         if(count(json_decode($return,true)) > 0){
//              DB::table('proxy')
//               ->update(['status' => 0]);
//              sleep(3);
//         }
//         curl_close($process);
$proxyDB = DB::table('proxy')->where('status', 1)->inRandomOrder()->first();
        $checkProxy = $this->check($proxyDB->url);
        $proxy = '';
        if ($checkProxy == true) {
            $proxy = $proxyDB->url;
        }
        $username = 'admin';
        $password = 'admin';
        $rest_api_url = 'https://johnnguyenn.com/wp-json/wp/v2/posts';
        $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczpcL1wvam9obm5ndXllbm4uY29tIiwiaWF0IjoxNTkwMjQ3NjgyLCJuYmYiOjE1OTAyNDc2ODIsImV4cCI6MTU5MDg1MjQ4MiwiZGF0YSI6eyJ1c2VyIjp7ImlkIjoiMSJ9fX0.r1HOZ0pOicwlPbYqqHPRyMYKxaL5z17rhJDCBOtJdO8";

        $data_string = json_encode([
    'title' => 'My title',
    'content' => 'My content',
    'status' => 'draft',
]);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $rest_api_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Content-Length: '.strlen($data_string),
       'Authorization: Bearer '.$token,
]);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_PROXY, $proxy);     // PROXY details with port
        //curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyauth);   // Use if proxy have username and password
        if ($proxyDB->type === 'SOCKS4') {
            curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS4); // If expected to call with specific PROXY type
        } else {
            curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5); // If expected to call with specific PROXY type
        }
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
        //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  // If url has redirects then go to the final redirected URL.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);  // Do not outputting it out directly on screen.
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);

        curl_close($ch);
        dd($result);
        if ($result) {
            // ...
        } else {
            // ...
        }
    }

    protected function curlGetPage($url = '')
    {
        $proxyDB = DB::table('proxy')->where('status', 1)->inRandomOrder()->first();
        $checkProxy = $this->check($proxyDB->url);
        $proxy = '';
        if ($checkProxy == true) {
            $proxy = $proxyDB->url;
        }

        error_reporting(E_ALL);
        // $url = 'https://www.quocbuugroup.com/thiet-ke-bo-nhan-dien-thuong-hieu.html';
        // $proxy = '127.0.0.1:8888';
        // $proxyauth = 'user:password';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);         // URL for CURL call
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 500);
        curl_setopt($ch, CURLOPT_TIMEOUT, 500);
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_PROXY, $proxy);     // PROXY details with port
        //curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyauth);   // Use if proxy have username and password
        if ($proxyDB->type === 'SOCKS4') {
            curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS4); // If expected to call with specific PROXY type
        } else {
            curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5); // If expected to call with specific PROXY type
        }
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
        //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  // If url has redirects then go to the final redirected URL.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);  // Do not outputting it out directly on screen.
        curl_setopt($ch, CURLOPT_HEADER, 1);   // If you want Header information of response else make 0
        $curl_scraped_page = curl_exec($ch);
        $status_code = @curl_getinfo($ch, CURLINFO_HTTP_CODE);

        //return $return;
        if (curl_errno($ch)) {
            $errorCode = curl_error($ch);
        }
        if (curl_error($ch) === 'Failed to receive SOCKS4 connect request ack.') {
            if ($checkProxy == true) {
                $proxy = $proxyDB->url;
            }
        }
        curl_close($ch);

        return json_decode($curl_scraped_page, true);
    }

    protected function uploadFile($token, $archivo)
    {
        $proxyDB = DB::table('proxy')->where('status', 1)->inRandomOrder()->first();
        $checkProxy = $this->check($proxyDB->url);
        $proxy = '';
        if ($checkProxy == true) {
            $proxy = $proxyDB->url;
        }
        $file = file_get_contents($archivo);
        //    $mime = mime_content_type($archivo);
        $url = 'https://johnnguyenn.com/wp-json/wp/v2/media';
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->getRandomUserAgent());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $file);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: image/jpeg',
        'Content-Disposition: attachment; filename="'.basename($archivo).'"',
        'Authorization: Bearer '.$token,
         'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
                'Accept-Encoding: gzip, deflate, br',
    ]);
        $cookieFile = 'cookies.txt';
        if (!file_exists($cookieFile)) {
            $fh = fopen($cookieFile, 'w');
            fwrite($fh, '');
            fclose($fh);
        }
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
        if ($proxyDB->type === 'SOCKS4') {
            curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS4);
        } else {
            curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
        }
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    protected function getRandomUserAgent()
    {
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
        $random = rand(0, count($userAgents) - 1);

        return $userAgents[$random];
    }

    protected function check($proxy = null)
    {
        $proxy = explode(':', $proxy);
        $host = $proxy[0];
        $port = $proxy[1];
        $waitTimeoutInSeconds = 30;
        if ($fp = @fsockopen($host, $port, $errCode, $errStr, $waitTimeoutInSeconds)) {
            return true;
        } else {
            return false;
        }
        fclose($fp);
    }

    protected function findranking($domain, $keyword)
    {
        usleep(400000 * rand(0, 16));
        $rank = 0;
        $url = 'http://www.google.com/search?q='.urlencode($keyword).'&num=10';
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_HEADER, 1); // set to 0 to eliminate header info from response
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
    $header = array();
        $headers[] = 'Accept: text/xml,application/xml,application/xhtml+xml,';
        $header[] .= 'text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5';
        $header[] = 'Cache-Control: max-age=0';
        $header[] = 'Connection: keep-alive';
        $header[] = 'Keep-Alive: 300';
        $header[] = 'Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7';
        $header[] = 'Accept-Language: en-us,en;q=0.5';
        $header[] = 'Pragma: '; // browsers keep this blank.
        if ($headers && !empty($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        // curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
        $resp = curl_exec($ch); //execute post and get results

        curl_close($ch);
        if (strpos($resp, 'Location: http://sorry.google.com/sorry/') && strpos($resp, '302 Found')) {
            return -200;
        }
        $count = 0;
        $bp = 0;

        while ($bp = strpos($resp, '<h3 class=', $bp + 1)) {
            ++$count;
            $end = strpos($resp, '</h3>', $bp);
            $link = substr($resp, $bp, $end - $bp + 5);
            ++$bp;
            if (stripos($link, '>Local business results for') && stripos($link, 'href="http://maps.google.com/')) {
                --$count;
            }

            if (stripos($link, 'http://'.$domain) || stripos($link, 'https://'.$domain) || stripos($link, 'http://www.'.$domain) || stripos($link, 'https://www.'.$domain)) {
                $rank = $count;
            }
        }
        if (!$rank) {
            $rank = 101;
        }

        return $rank;
    }

    public function fread_url($url, $ref = '')
    {
        if (function_exists('curl_init')) {
            $ch = curl_init();
            $user_agent = 'Mozilla/4.0 (compatible; MSIE 5.01; '.
                          'Windows NT 5.0)';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_REFERER, $ref);
            curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
            $html = curl_exec($ch);
            curl_close($ch);
        } else {
            $hfile = fopen($url, 'r');
            if ($hfile) {
                while (!feof($hfile)) {
                    $html .= fgets($hfile, 1024);
                }
            }
        }

        return $html;
    }

    public function getinboundLinks($domain_name)
    {
        ini_set('user_agent', 'NameOfAgent (<a class="linkclass" href="http://localhost">http://localhost</a>)');
        $url = $domain_name;
        $url_without_www = str_replace('http://', '', $url);
        $url_without_www = str_replace('www.', '', $url_without_www);
        $url_without_www = str_replace(strstr($url_without_www, '/'), '', $url_without_www);
        $url_without_www = trim($url_without_www);
        $input = @file_get_contents($url) or die('Could not access file: $url');
        $regexp = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>(.*)<\/a>";
        //$inbound=0;
        $outbound = 0;
        $nonfollow = 0;
        if (preg_match_all("/$regexp/siU", $input, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                // $match[2] = link address
                // $match[3] = link text
                //echo $match[3].'<br>';
                if (!empty($match[2]) && !empty($match[3])) {
                    if (strstr(strtolower($match[2]), 'URL:') || strstr(strtolower($match[2]), 'url:')) {
                        ++$nonfollow;
                    } elseif (strstr(strtolower($match[2]), $url_without_www) || !strstr(strtolower($match[2]), 'http://')) {
                        ++$inbound;
                        echo '<br>inbound '.$match[2];
                    } elseif (!strstr(strtolower($match[2]), $url_without_www) && strstr(strtolower($match[2]), 'http://')) {
                        echo '<br>outbound '.$match[2];
                        ++$outbound;
                    }
                }
            }
        }
        $links['inbound'] = $inbound;
        $links['outbound'] = $outbound;
        $links['nonfollow'] = $nonfollow;

        return $links;
    }

    public function crawl_page($page_url, $domain)
    {
        /* $page_url - page to extract links from, $domain -
            crawl only this domain (and subdomains)
            Returns an array of absolute URLs or false on failure.
        */

        /* I'm using cURL to retrieve the page */
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $page_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

        /* Spoof the User-Agent header value; just to be safe */
        curl_setopt(
            $ch,
            CURLOPT_USERAGENT,
            'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)'
        );

        /* I set timeout values for the connection and download
        because I don't want my script to get stuck
        downloading huge files or trying to connect to
        a nonresponsive server. These are optional. */
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);

        /* This ensures 404 Not Found (and similar) will be
            treated as errors */
        curl_setopt($ch, CURLOPT_FAILONERROR, true);

        /* This might/should help against accidentally
          downloading mp3 files and such, but it
          doesn't really work :/  */
        $header[] = 'Accept: text/html, text/*';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        /* Download the page */
        $html = curl_exec($ch);
        curl_close($ch);

        if (!$html) {
            return false;
        }

        /* Extract the BASE tag (if present) for
          relative-to-absolute URL conversions later */
        if (preg_match('/<base&#91;\s&#93;+href=\s*&#91;\"\'&#93;?(&#91;^\'\" >]+)[\'\" >]/i', $html, $matches)) {
            $base_url = $matches[1];
        } else {
            $base_url = $page_url;
        }

        $links = array();

        $html = str_replace("\n", ' ', $html);
        preg_match_all('/<a&#91;\s&#93;+&#91;^>]*href\s*=\s*([\"\']+)([^>]+?)(\1|>)/i', $html, $m);
        /* this regexp is a combination of numerous
            versions I saw online; should be good. */

        foreach ($m[2] as $url) {
            $url = trim($url);

            /* get rid of PHPSESSID, #linkname, &amp; and javascript: */
            $url = preg_replace(
                array('/([\?&]PHPSESSID=\w+)$/i', '/(#[^\/]*)$/i', '/&amp;/', '/^(javascript:.*)/i'),
                array('', '', '&', ''),
                $url
            );

            /* turn relative URLs into absolute URLs.
              relative2absolute() is defined further down
              below on this page. */
            $url = relative2absolute($base_url, $url);

            // check if in the same (sub-)$domain
            if (preg_match("/^http[s]?:\/\/[^\/]*".str_replace('.', '\.', $domain).'/i', $url)) {
                //save the URL
                if (!in_array($url, $links)) {
                    $links[] = $url;
                }
            }
        }

        return $links;
    }

    public function getUrls($url = '')
    {
        $urls = [];

        if ($url != '') {
            $baseUrl = $url;
            $prefix = 'https';
            if (strpos($baseUrl, 'ttps://') === false) {
                $prefix = 'http';
            }
            $client = new Client();
            $response = $client->request('GET', $url);
            $html = $response->getBody();
            //Getting the exact url without http or https
            $url = str_replace('http://www.', '', $url);
            $url = str_replace('https://www.', '', $url);
            $url = str_replace('http://', '', $url);
            $url = str_replace('https://', '', $url);
            //Parsing the url for getting host information
            $parse = parse_url('https://'.$url);
            //Parsing the html of the base url
            $dom = new \DOMDocument();
            @$dom->loadHTML($html);
            // grab all the on the page
            $xpath = new \DOMXPath($dom);
            //finding the a tag
            $hrefs = $xpath->evaluate('/html/body//a');
            //Loop to display all the links
            $length = $hrefs->length;
            //Converting URLs to add the www prefix to host to a common array
            $baseUrl = str_replace('http://'.$parse['host'], 'http://www.'.$parse['host'], $baseUrl);
            $baseUrl = str_replace('https://'.$parse['host'], 'https://www.'.$parse['host'], $baseUrl);
            $urls = [$baseUrl];
            $allUrls = [$baseUrl];
            for ($i = 0; $i < $length; ++$i) {
                $href = $hrefs->item($i);
                $url = $href->getAttribute('href');
                $url = str_replace('http://'.$parse['host'], 'http://www.'.$parse['host'], $url);
                $url = str_replace('https://'.$parse['host'], 'https://www.'.$parse['host'], $url);
                //Replacing the / at the end of any url if present
                if (substr($url, -1, 1) == '/') {
                    $url = substr_replace($url, '', -1);
                }
                array_push($allUrls, $url);
            }

            //Looping for filtering the URLs into a distinct array
            foreach ($allUrls as $url) {
                //Limiting the number of urls on the site
                if (count($urls) >= 300) {
                    break;
                }
                //Filter the null links and images
                if (strpos($url, '#') === false) {
                    //Filtering the links with host
                    if (strpos($url, 'https://'.$parse['host']) !== false || strpos($url, 'https://www.'.$parse['host']) !== false) {
                        //Replacing the / at the end of any url if present
                        if (substr($url, -1, 1) == '/') {
                            $url = substr_replace($url, '', -1);
                        }
                        //Checking if the link is already preset in the final array
                        $urlSuffix = str_replace('http://www.', '', $url);
                        $urlSuffix = str_replace('https://www.', '', $urlSuffix);
                        $urlSuffix = str_replace('http://', '', $urlSuffix);
                        $urlSuffix = str_replace('https://', '', $urlSuffix);

                        if ($urlSuffix != $parse['host']) {
                            array_push($urls, $url);
                        }
                    }
                    //Filtering the links without host
                    if (strpos($url, $parse['host']) === false) {
                        if (substr($url, 0, 1) == '/') {
                            //Replacing the / at the end of any url if present
                            if (substr($url, -1, 1) == '/') {
                                $url = substr_replace($url, '', -1);
                            }
                            $newUrl = 'http://www.'.$parse['host'].$url;
                            $secondUrl = 'https://www.'.$parse['host'].$url;
                            if ($url != $parse['host']) {
                                //Checking if the link is already preset in the final array and the common array
                                if (!in_array($secondUrl, $urls) && !in_array($secondUrl, $allUrls) && !in_array($newUrl, $allUrls)) {
                                    if ($prefix == 'https') {
                                        $newUrl = $secondUrl;
                                    }
                                    array_push($urls, $newUrl);
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
