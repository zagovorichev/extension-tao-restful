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
 *
 * @author Alexander Zagovorichev <zagovorichev@1pt.com>
 */

namespace oat\taoRestAPI\test\v1;


use oat\tao\test\TaoPhpUnitTestRunner;
use oat\taoRestAPI\model\v1\http\Request\DataFormat;
use oat\taoRestAPI\service\v1\RestApiService;
use oat\taoRestAPI\test\v1\Mocks\EnvironmentTrait;
use oat\taoRestAPI\test\v1\Mocks\TestHttpRoute;

class RestApiServiceTest extends TaoPhpUnitTestRunner
{
    use EnvironmentTrait;

    /**
     * @var RestApiService
     */
    private $service;

    public function setUp()
    {
        parent::setUp();
        $this->service = new RestApiService();
    }

    public function testServiceAuth(){}
    
    public function testServiceWithoutRoute(){}
    
    public function testServiceGetList()
    {
        $this->request('GET', '/resources', function ($req, $res, $args) {
            
            $this->service
                //->setAuth(new BasicAuthentication())
                ->setEncoder(new DataFormat())
                ->setRouter(new TestHttpRoute())
                ->execute(function ($router) use ($req, &$res) {
                    $router($req, $res);
                });
            
            return $this->response = $res;
        });

        $this->assertEquals(5, count($this->response->getResourceData()));
        $this->assertEquals(5, count($this->response->getResourceData()[0]));
        $this->assertEquals(200, $this->response->getStatusCode());
        $this->assertEquals('OK', $this->response->getReasonPhrase());
        $this->assertEquals(['0-4/5'], $this->response->getHeader('Content-Range'));
        $this->assertEquals(['resource 50'], $this->response->getHeader('Accept-Range'));
    }
}
