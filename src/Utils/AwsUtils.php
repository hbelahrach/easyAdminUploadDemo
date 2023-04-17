<?php

namespace App\Utils;

use Aws\S3\S3Client;
use Symfony\Component\HttpFoundation\File\File;

class AwsUtils
{
    private S3Client $client;
    public function __construct()
    {
        $this->client = new S3Client([
            "region" => $_ENV['AWS_REGION'],
            "version" => $_ENV['AWS_VERSION'],
            "credentials" => [
                "key" => $_ENV['AWS_KEY'],
                "secret" => $_ENV['AWS_SECRET']
            ]
        ]);
    }

    public function uploadFile(File $file, string $fileName) {
        $this->client->putObject([
            'Bucket' => $_ENV['AWS_BUCKET'],
            'Key' => $fileName,
            'SourceFile' => $file,
            'ACL' => 'public-read'
        ]);
    }
}