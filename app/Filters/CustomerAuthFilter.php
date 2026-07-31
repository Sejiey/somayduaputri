<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class CustomerAuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        if ($session->get('pembeli_id')) {
            return;
        }

        $currentPath = uri_string();
        $redirectParam = ! empty($currentPath) ? '?redirect=' . urlencode(ltrim($currentPath, '/')) : '';

        return redirect()->to('/login' . $redirectParam)
            ->with('error', 'Silakan login atau daftar terlebih dahulu untuk melanjutkan.');
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
