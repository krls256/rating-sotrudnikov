<?php 
include __DIR__ . "/../vendor/autoload.php";
include __DIR__ . "/../vendor/somesh/php-query/phpQuery/phpQuery.php";

use GuzzleHttp\Client;

class Neorabote 
{
    private $client;
    private $url    = 'https://neorabote.net/'; 
    private $review = [];

    function __construct(array $proxy = []) 
    {
        $options = [
            'base_uri'  => $this->url,
            'timeout'   => 2.0,
            'cookies'   => true,
            'headers'   => [
                'User-Agent'    => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.16; rv:85.0) Gecko/20100101 Firefox/85.0',
                'referer'       => $this->url
            ]
        ];

        # Если переданы прокси
        if (count($proxy) !== 0) {
            $index = rand(0, count($proxy));
            $options['proxy']['http'] = $proxy[$index];
        }

        $this->client = new Client($options);
    }

    /**
     * Получаем html
     * 
     * @param $id   - ID в сервесе
     * @param $page - Номер страницы
     * 
     * @return strung
     */
    public function get(int $id, int $page) 
    { 
        $response = $this->client->request("GET", "/feedback/list/company/$id/page/$page");

        if ( $response->getStatusCode() == 404 ) {
            return false;
        }

        return $response->getBody();
    }

    /**
     * Собераем все отзывы о компании
     * 
     * @param $id - ID в сервесе
     * 
     * @return void
     */
    public function collect(int $id)
    { 
        $page   = 1;
        $next   = true;
        $ret    = ''; 

        do { 
            $html = $this->get($id, $page);

            if ( !$html ) 
                $next = false;

            $this->all($html);

            $page++;
            sleep(rand(1,3));
        } while ($next);
    }

    /**
     * 
     */
    public function all(string $html) 
    { 
        $doc = phpQuery::newDocument($html);
        var_dump($doc);
    }
}
?>