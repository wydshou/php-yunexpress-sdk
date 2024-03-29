<?php

namespace Laradocs\Tests\Unit;

use GuzzleHttp\Psr7\Response;
use Laradocs\YunExpress\Client;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client as Guzzle;
use Mockery;

class ClientTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function testGetCountry()
    {
        $factory = Mockery::mock(Client::class . '[factory]', ['xxx']);
        $factory->shouldReceive('factory')->andReturn($this->factory());
        $data = $factory->getCountry();
        $this->assertNotEmpty($data);
        $this->assertSame('AD', $data[0]['CountryCode']);
    }

    public function testGetShippingMethods()
    {
        $factory = Mockery::mock(Client::class . '[factory]', ['xxx']);
        $factory->shouldReceive('factory')->andReturn($this->factory());
        $data = $factory->getShippingMethods();
        $this->assertNotEmpty($data);
        $this->assertSame('ZDZXR', $data[0]['Code']);
    }

    public function testGetGoodsType()
    {
        $factory = Mockery::mock(Client::class . '[factory]', ['xxx']);
        $factory->shouldReceive('factory')->andReturn($this->factory());
        $data = $factory->getGoodsType();
        $this->assertNotEmpty($data);
        $this->assertSame(2, $data[0]['Id']);
    }

    public function testGetPriceTrial()
    {
        $factory = Mockery::mock(Client::class . '[factory]', ['xxx']);
        $factory->shouldReceive('factory')->andReturn($this->factory());
        $data = $factory->getPriceTrial('US', 0.2);
        $this->assertEmpty($data);
    }

    public function testGetTrackingNumber()
    {
        $factory = Mockery::mock(Client::class . '[factory]', ['xxx']);
        $factory->shouldReceive('factory')->andReturn($this->factory());
        $data = $factory->getTrackingNumber('xxx');
        $this->assertNotEmpty($data);
        $this->assertSame(2, $data[0]['Status']);
    }

    public function testGetSender()
    {
        $factory = Mockery::mock(Client::class . '[factory]', ['xxx']);
        $factory->shouldReceive('factory')->andReturn($this->factory());
        $data = $factory->getSender('xxx');
        $this->assertNotEmpty($data);
        $this->assertSame('CN', $data['CountryCode']);
    }

    public function testCreateOrder()
    {
        $factory = Mockery::mock(Client::class . '[factory]', ['xxx']);
        $factory->shouldReceive('factory')->andReturn($this->factory());
        $data = $factory->createOrder(['xxx']);
        $this->assertNotEmpty($data);
        $this->assertSame(1, $data[0]['Success']);
    }

    public function testGetOrder()
    {
        $factory = Mockery::mock(Client::class . '[factory]', ['xxx']);
        $factory->shouldReceive('factory')->andReturn($this->factory());
        $data = $factory->getOrder('xxx');
        $this->assertNotEmpty($data);
        $this->assertSame('BKPHR', $data['ShippingMethodCode']);
    }

    public function testUpdateWeight()
    {
        $factory = Mockery::mock(Client::class . '[factory]', ['xxx']);
        $factory->shouldReceive('factory')->andReturn($this->factory());
        $data = $factory->updateWeight('2022021008567562', 0.4);
        $this->assertNotEmpty($data);
        $this->assertSame('success', $data['Status']);
    }

    public function testDelete()
    {
        $factory = Mockery::mock(Client::class . '[factory]', ['xxx']);
        $factory->shouldReceive('factory')->andReturn($this->factory());
        $data = $factory->delete(2, '2022021008567562');
        $this->assertNotEmpty($data);
        $this->assertSame('2022021008567562', $data['OrderNumber']);
    }

    public function testIntercept()
    {
        $factory = Mockery::mock(Client::class . '[factory]', ['xxx']);
        $factory->shouldReceive('factory')->andReturn($this->factory());
        $data = $factory->intercept(2, '2022021008567562', '测试拦截');
        $this->assertNotEmpty($data);
        $this->assertSame('2022021008567562', $data['OrderNumber']);
    }

    public function testLabelPrint()
    {
        $factory = Mockery::mock(Client::class . '[factory]', ['xxx']);
        $factory->shouldReceive('factory')->andReturn($this->factory());
        $data = $factory->labelPrint(['2022021008567562']);
        $this->assertNotEmpty($data);
        $this->assertSame(100, $data[0]['OrderInfos'][0]['Code']);
    }

    public function testGetShippingFeeDetail()
    {
        $factory = Mockery::mock(Client::class . '[factory]', ['xxx']);
        $factory->shouldReceive('factory')->andReturn($this->factory());
        $data = $factory->getShippingFeeDetail('xxx');
        $this->assertNotEmpty($data);
        $this->assertSame('US', $data['CountryCode']);
    }

    public function testRegister()
    {
        $factory = Mockery::mock(Client::class . '[factory]', ['xxx']);
        $factory->shouldReceive('factory')->andReturn($this->factory());
        $data = $factory->register('xxx', 'xxx', 'xxx', 'xxx', 'xxx', 'xxx', 'xxx', 'xxx', 2);
        $this->assertNotEmpty($data);
        $this->assertSame('C12345', $data['CustomerCode']);
    }

    public function testGetTrackInfo()
    {
        $factory = Mockery::mock(Client::class . '[factory]', ['xxx']);
        $factory->shouldReceive('factory')->andReturn($this->factory());
        $data = $factory->getTrackInfo('xxx');
        $this->assertNotEmpty($data);
        $this->assertSame('AU', $data['CountryCode']);
    }

    public function testGetTrackAllInfo()
    {
        $factory = Mockery::mock(Client::class . '[factory]', ['xxx']);
        $factory->shouldReceive('factory')->andReturn($this->factory());
        $data = $factory->getTrackAllInfo('xxx');
        $this->assertNotEmpty($data);
        $this->assertSame('AU', $data['CountryCode']);
    }

    public function testGetCarrier()
    {
        $factory = Mockery::mock(Client::class . '[factory]', ['xxx']);
        $factory->shouldReceive('factory')->andReturn($this->factory());
        $data = $factory->getCarrier(['xxx']);
        $this->assertNotEmpty($data);
        $this->assertSame('CAZX', $data[0]['CarrierCode']);
    }

    public function testRegisterIoss()
    {
        $factory = Mockery::mock(Client::class . '[factory]', ['xxx']);
        $factory->shouldReceive('factory')->andReturn($this->factory());
        $data = $factory->registerIoss(0, null, 'xxx');
        $this->assertNotEmpty($data);
        $this->assertSame('0000', $data['Code']);
    }

    protected function factory()
    {
        $factory = Mockery::mock(Guzzle::class);
        $factory->shouldReceive('get')->withAnyArgs()->andReturnUsing(function ($url) {
            if (str_contains($url, 'GetCountry')) {
                $body = file_get_contents(__DIR__ . '/../get_country.json');
            }
            if (str_contains($url, 'GetShippingMethods')) {
                $body = file_get_contents(__DIR__ . '/../get_shipping_methods.json');
            }
            if (str_contains($url, 'GetGoodsType')) {
                $body = file_get_contents(__DIR__ . '/../get_goods_type.json');
            }
            if (str_contains($url, 'GetPriceTrial')) {
                $body = file_get_contents(__DIR__ . '/../get_price_trial.json');
            }
            if (str_contains($url, 'GetTrackingNumber')) {
                $body = file_get_contents(__DIR__ . '/../get_tracking_number.json');
            }
            if (str_contains($url, 'GetSender')) {
                $body = file_get_contents(__DIR__ . '/../get_sender.json');
            }
            if (str_contains($url, 'GetOrder')) {
                $body = file_get_contents(__DIR__ . '/../get_order.json');
            }
            if (str_contains($url, 'GetShippingFeeDetail')) {
                $body = file_get_contents(__DIR__ . '/../get_shipping_fee_detail.json');
            }
            if (str_contains($url, 'GetTrackInfo')) {
                $body = file_get_contents(__DIR__ . '/../get_track_info.json');
            }
            if (str_contains($url, 'GetTrackAllInfo')) {
                $body = file_get_contents(__DIR__ . '/../get_track_all_info.json');
            }

            return new Response(200, [], $body);
        });
        $factory->shouldReceive('post')->withAnyArgs()->andReturnUsing(function ($url) {
            if (str_contains($url, 'CreateOrder')) {
                $body = file_get_contents(__DIR__ . '/../create_order.json');
            }
            if (str_contains($url, 'UpdateWeight')) {
                $body = file_get_contents(__DIR__ . '/../update_weight.json');
            }
            if (str_contains($url, 'Delete')) {
                $body = file_get_contents(__DIR__ . '/../delete.json');
            }
            if (str_contains($url, 'Intercept')) {
                $body = file_get_contents(__DIR__ . '/../intercept.json');
            }
            if (str_contains($url, 'Label/Print')) {
                $body = file_get_contents(__DIR__ . '/../label_print.json');
            }
            if (str_contains($url, 'Register')) {
                $body = file_get_contents(__DIR__ . '/../register.json');
            }
            if (str_contains($url, 'GetCarrier')) {
                $body = file_get_contents(__DIR__ . '/../get_carrier.json');
            }
            if (str_contains($url, 'RegisterIoss')) {
                $body = file_get_contents(__DIR__ . '/../register_ioss.json');
            }

            return new Response(200, [], $body);
        });

        return $factory;
    }
}
