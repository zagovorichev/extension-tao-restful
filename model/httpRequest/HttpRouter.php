<?php
/**
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; under version 2
 * of the License (non-upgradable).
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 *
 * Copyright (c) 2016  (original work) Open Assessment Technologies SA;
 */

namespace oat\taoRestAPI\model\httpRequest;


use oat\taoRestAPI\exception\HttpRequestException;
use oat\taoRestAPI\model\HttpRouterInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class HttpRouter implements HttpRouterInterface
{

    protected $req;
    
    private $res;
    
    private $resourceId;
    
    public function __construct(ServerRequestInterface $req, ResponseInterface $res)
    {
        $this->req = $req;
        $this->res = $res;
        $this->resourceId = $this->getResourceId();
    }
    
    private function getResourceId()
    {
        return $this->req->getAttribute('id');
    }

    public function router()
    {
        $method = strtolower($this->req->getMethod());

        if (!method_exists($this, $method)) {
            throw new HttpRequestException(__('Unsupported HTTP request method'));
        }

        return $this->$method();
    }

    abstract protected function getList();
    
    abstract protected function getOne();
    
    public function get()
    {
        
        return empty($this->resourceId) 
            ? $this->getList()
            : $this->getOne();
    }

    public function post()
    {
        if (!empty($this->resourceId)) {
            throw new HttpRequestException(__('You can\'t create new resource on object'));
        }
    }

    public function put()
    {
        if (empty($this->resourceId)) {
            throw new HttpRequestException(__('You can\'t update list of the resources'));
        }
    }

    public function patch()
    {
        if (empty($this->resourceId)) {
            throw new HttpRequestException(__('You can\'t update list of the resources'));
        }
    }

    public function delete()
    {
        if (empty($this->resourceId)) {
            throw new HttpRequestException(__('You can\'t delete list of the resources'));
        }
    }

    public function options()
    {
        return empty($this->resourceId)
            ? ['POST', 'GET', 'OPTIONS']
            : ['GET', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'];
    }
}
