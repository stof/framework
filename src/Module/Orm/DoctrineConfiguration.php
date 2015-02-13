<?php

namespace Somos\Module\Orm;

final class DoctrineConfiguration
{
    private $debug = false;
    private $connection = ['driver' => 'pdo_sqlite', 'path' => 'db.sqlite'];
    private $metadataConfiguration = ['type' => 'xml', 'paths' => ['config/doctrine']];

    public function __construct($connection = ['driver' => 'pdo_sqlite', 'path' => 'db.sqlite'])
    {
        $this->connection = $connection;
    }

    public function enableDebugging()
    {
        $this->debug = true;
    }

    public function useAnnotations(array $entityLocations)
    {
        $this->metadataConfiguration = ['type' => 'annotation', 'paths' => $entityLocations];
    }

    public function useXml(array $schemaPath = ['config/doctrine'])
    {
        $this->metadataConfiguration = ['type' => 'xml', 'paths' => $schemaPath];
    }

    public function useYml(array $schemaPath = ['config/doctrine'])
    {
        $this->metadataConfiguration = ['type' => 'yml', 'paths' => $schemaPath];
    }

    public function toDiArray()
    {
        return [
            'doctrine.debug' => $this->debug,
            'doctrine.connection' => $this->connection,
            'doctrine.metadata.configuration' => $this->metadataConfiguration,
        ];
    }
}