<?php


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PrototypeControllerTest extends WebTestCase
{
    public function testGetFails()
    {
        $client = static::createClient();
        $client->request('GET', '/extract');
        $this->assertEquals(405, $client->getResponse()->getStatusCode());
    }

    public function testPostWithoutFileFails()
    {
        $client = static::createClient();
        $client->request('POST', '/extract');
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }

    public function testUpload()
    {
        $client = static::createClient();
        $excel = new UploadedFile(__DIR__ . DIRECTORY_SEPARATOR . 'DataSet_ACME_fees.xlsx', 'DataSet_ACME_fees.xlsx');
        $client->request('POST', '/extract', [], [$excel]);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

}
