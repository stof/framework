<?php

namespace Somos\Module\Orm;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Somos\Module;

final class Doctrine implements Module
{
    /** @var DoctrineConfiguration */
    private $configuration;

    public function __construct(DoctrineConfiguration $configuration = null)
    {
        $this->configuration = $configuration ?: new DoctrineConfiguration();
    }

    public function __invoke()
    {
        $configuration = $this->configuration->toDiArray();

        $configuration[EntityManager::class] = \DI\factory(
            function () {
                $isDevMode = \DI\link('doctrine.debug');
                $metadataConfiguration = \DI\link('doctrine.metadata.configuration');
                $paths = $metadataConfiguration['paths'];

                switch($metadataConfiguration['type']) {
                    case 'xml':
                        $metadata = Setup::createXMLMetadataConfiguration($paths, $isDevMode);
                        break;
                    case 'yml':
                        $metadata = Setup::createYAMLMetadataConfiguration($paths, $isDevMode);
                        break;
                    case 'annotations':
                        $metadata = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
                        break;
                    default:
                        throw new \InvalidArgumentException(
                            'Doctrine can only load its configuration using "xml", "yml" or "annotations" but "'
                            . $metadataConfiguration['type'] . '" was provided as a means.'
                        );
                }

                return EntityManager::create(\DI\link('doctrine.connection'), $metadata);
            }
        );

        return $configuration;
    }
}