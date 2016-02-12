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

namespace oat\taoRestAPI\model\v1\http\Request;


use oat\taoRestAPI\exception\HttpRequestException;
use oat\taoRestAPI\model\HttpRouterInterface;

abstract class Router implements HttpRouterInterface
{

    /**
     * @var mixed
     */
    private $resourceId;

    public function get()
    {
        empty($this->resourceId)
            ? $this->getList()
            : $this->getOne();
    }

    abstract protected function getList();

    abstract protected function getOne();

    public function post()
    {
        if (!empty($this->resourceId)) {
            throw new HttpRequestException(__('Forbidden to creating new resource on object'), 400);
        }
    }

    public function put()
    {
        if (empty($this->resourceId)) {
            throw new HttpRequestException(__('Forbidden to updating list of the resources'), 400);
        }
    }

    public function patch()
    {
        if (empty($this->resourceId)) {
            throw new HttpRequestException(__('Forbidden to updating list of the resources'), 400);
        }
    }

    public function delete()
    {
        if (empty($this->resourceId)) {
            throw new HttpRequestException(__('Forbidden to deleting list of the resources'), 400);
        }
    }

    public function options()
    {
        return empty($this->resourceId)
            ? ['POST', 'GET', 'OPTIONS']
            : ['GET', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'];
    }

    protected function getResourceId()
    {
        return $this->resourceId;
    }

    /**
     * @param null $id
     */
    protected function setResourceId($id = null)
    {
        $this->resourceId = $id;
    }
}
