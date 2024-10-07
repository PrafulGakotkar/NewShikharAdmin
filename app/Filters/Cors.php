<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Cors implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Allow from any origin (you can restrict this by replacing '*' with specific domain)
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

        // // If the request method is OPTIONS (Preflight request), exit early with necessary headers
        // if ($request->getMethod() === 'options') {
        //     header('HTTP/1.1 204 No Content');
        //     header('Content-Length: 0');
        //     header('Access-Control-Allow-Origin: *');
        //     header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
        //     header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
        //     exit();
        // }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Add the CORS headers to the response to ensure they are always set
        $response->setHeader('Access-Control-Allow-Origin', '*');
        $response->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE');
        $response->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
    }
}
