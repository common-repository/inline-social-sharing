<?php

// https://github.com/abeMedia/shareCount

class shareCount
{
    private $data;
    private $url;
    private $services;

    public function __construct()
    {
        $this->data = new stdClass();
    }

    // query API to get share counts
    public function getShares()
    {
        $this->url =  $_POST['url'];

        $services = $services ?: $this->services;
        $shareLinks = array(
            'facebook' => array('http://graph.facebook.com/?ids=', 'GET'),
            'google' => array('https://apis.google.com/u/0/se/0/_/+1/sharebutton?plusShare=true&url=', 'GET'),
            'linkedin' => array('https://www.linkedin.com/countserv/count/share?format=json&url=', 'GET'),
            'pinterest' => array('http://api.pinterest.com/v1/urls/count.json?url=', 'GET'),
            'stumbleupon' => array('http://www.stumbleupon.com/services/1.01/badge.getinfo?url=', 'GET'),
            'reddit' => array('http://www.reddit.com/api/info.json?&url=', 'GET'),
            'buffer' => array('https://api.bufferapp.com/1/links/shares.json?url=', 'GET'),
            'vk' => array('http://vk.com/share.php?act=count&index=1&url=', 'GET'),
            'addthis' => array('http://api-public.addthis.com/url/shares.json?url=', 'GET'),
            'flattr' => array('https://api.flattr.com/rest/v2/things/lookup/?url=', 'GET'),
            'xing' => array('https://www.xing-share.com/spi/shares/statistics?url=', 'POST'),
        );

        foreach ($shareLinks as $service => $provider) {
            @$this->getCount($service, $provider[0].$this->url, $provider[1]);
        }

        echo json_encode($this->data);
        die();
    }

    // query API to get share counts
    private function getCount($service, $url, $method = 'GET')
    {
        if (function_exists('curl_version')) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_USERAGENT, 'shareCount/1.2 by abemedia');
            if ($method == 'POST') {
                $url = explode('?', $url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $url[1]);
                $url = $url[0];
            }
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 1);
            @$data = curl_exec($ch);
            curl_close($ch);
        } else {
            if ($method == 'POST') {
                $url = explode('?', $url);
                $params = array('http' => array(
                    'method' => 'POST',
                    'header' => 'Content-type: application/x-www-form-urlencoded',
                    'content' => $url[1],
                ));
                $url = $url[0];
                $data = @file_get_contents($url, false, stream_context_create($params));
            } else {
                $data = @file_get_contents($url);
            }
        }
        if ($data) {
            switch ($service) {
            case 'facebook':
                $data = json_decode($data, true);
                $count = $data[$this->url]['share']['share_count'];
                break;
            case 'google':
                preg_match('/window\.__SSR = {c: ([\d]+)/', $data, $matches);
                $count = isset($matches[1]) ? $matches[1] : 0;
                break;
            case 'pinterest':
                $data = substr($data, 13, -1);
            case 'linkedin':
                $data = json_decode($data);
                $count = $data->count;
                break;
            case 'stumbleupon':
                $data = json_decode($data);
                $count = $data->result->in_index ? $data->result->views : 0;
                break;
            case 'reddit':
                $data = json_decode($data);
                $count = 0;
                foreach ($data->data->children as $child) {
                    $count += $child->data->score;
                }
                break;
            case 'addthis':
            case 'buffer':
                $data = json_decode($data);
                $count = $data->shares;
                break;
            case 'vk':
                $data = preg_match('/^VK.Share.count\(\d+,\s+(\d+)\);$/i', $data, $matches);
                $count = $matches[1];
                break;
            case 'flattr':
                $data = json_decode($data);
                $count = @$data->flattrs;// maybe not : {"message":"not_found","description":"No thing was found"}
                break;
            case 'xing':
                $data = json_decode($data);
                $count = @$data->share_counter;
                break;
            default:
                // kill the script if trying to fetch from a provider that doesn't exist
                die('Error: Service ('.$service.') not found');
            }
            $count = (int) $count;
            $this->data->shares->total += $count;
            $this->data->shares->$service = $count;
        } else {
            $this->data->shares->$service = '';
        }

        return;
    }
}
