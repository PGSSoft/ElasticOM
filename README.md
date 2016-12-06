![PGS Software](https://github.com/PGSSoft/ParallaxView/raw/master/Assets/pgssoft-logo.png)

# PGS Software / ElasticOM

[![Latest Stable Version](https://img.shields.io/packagist/v/pgs-soft/elastic-om.svg)](https://packagist.org/packages/pgs-soft/elastic-om)
[![PHP Version](https://img.shields.io/badge/php-%3E%3D%207.0-8892BF.svg)](https://php.net)
[![License](https://img.shields.io/github/license/PGSSoft/ElasticOM.svg)](https://packagist.org/packages/pgs-soft/elastic-om)
[![Build Status](https://travis-ci.org/PGSSoft/ElasticOM.svg?branch=master)](https://travis-ci.org/PGSSoft/ElasticOM)

Elasticsearch Object Mapper. Includes integration with Symfony 2.7+ and Zend Framework 3.


## Installation
```bash
    composer require pgs-soft/elastic-om
```


## Entity type configuration
Elasticsearch type(s) are configured basing on entities annotations, e.g.

```php
    use Pgs\ElasticOM\Annotation as ODM;

    class Book
    {
        /**
         * @var string
         * @ODM\Id
         * @ODM\Field(type="string")
         */
        private $id;

        /**
         * @var Author
         * @ODM\Field(type="nested", targetClass="AppBundle\Entity\Author")
         */
        private $author;

        /**
         * @var string
         * @ODM\Field(type="string")
         */
        private $title;

        // ...
    }
```


## Usage
```php
    use Pgs\ElasticOM\ElasticApi\ApiServiceFactory;

    $api = ApiServiceFactory::create('localhost', '9200', 'elastic_om');

    // creating index 'elastic_om'
    $api->createIndex();

    // creating type Book
    $api->createType(Book::class);

    // updating type Book
    $api->updateType(Book::class);
```


### Available annotations

#### Id

Marks class property to be used as unique object identifier. Only one property can be marked as Id.

#### Field

Specifies property to be mapped into elasticsearch type. Available parameters:

 - **type** - elasticsearch mapping type for the property. List of all types can be found here: https://www.elastic.co/guide/en/elasticsearch/reference/current/mapping-types.html
 - **targetClass** - if type is _object_ or _nested_, **targetClass** specifies nested object class

## Integrations

### Symfony
```php
    // app/AppKernel.php

    public function registerBundles()
    {
        $bundles = [
            // ...
            new Pgs\ElasticOM\Bridge\Symfony\ElasticOMBundle(),
            // ...
        ];
    }
```

```yaml
    # app/config.yml
    elastic_om:
        host: 'localhost'
        port: 9200
        index: 'elastic_om'
```

```php
    $slug = $this->get('elastic_om.entity_repository_manager')
        ->getRepository(Author::class)
        ->update(new Author());
```


### Zend Framework 3

```php
    // config/modules.config.php
    return [
        // ...
        'Pgs\ElasticOM\Bridge\ZF3',
    ];
```

```php
    // module/Application/config/module.config.php
    'controllers' => [
        'factories' => [
            ExampleController::class => function ($em) {
                return new ExampleController($em->get('elastic_om.entity_repository_manager'));
            },
        ],
    ],
```

```php
    // config/module.config.php
    return [
        // ...
        'elastic_om' => [
            'host' => 'localhost',
            'port' => '9200',
            'index' => 'elastic_om',
        ],
        // ...
    ];
```


## Contributing

Bug reports and pull requests are welcome on GitHub at [https://github.com/PGSSoft/ElasticOM](https://github.com/PGSSoft/ElasticOM).


## About

The project maintained by [software development agency](https://www.pgs-soft.com/) [PGS Software](https://www.pgs-soft.com/).
See our other [open-source projects](https://github.com/PGSSoft) or [contact us](https://www.pgs-soft.com/contact-us/) to develop your product.


## Follow us

[![Twitter URL](https://img.shields.io/twitter/url/http/shields.io.svg?style=social)](https://twitter.com/intent/tweet?text=https://github.com/PGSSoft/InAppPurchaseButton)
[![Twitter Follow](https://img.shields.io/twitter/follow/pgssoftware.svg?style=social&label=Follow)](https://twitter.com/pgssoftware)
