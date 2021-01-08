<?php
declare(strict_types=1);

namespace App\Tests\Service;

use App\Service\XmlClosureParser;
use App\Tests\Serialization\DependenciesXml;
use PHPUnit\Framework\TestCase;

class XmlClosureParserTest extends TestCase
{
    public function testXmlToArray()
    {
        $simpleXml = simplexml_load_string(DependenciesXml::get());
        $xmlParser = new XmlClosureParser();
        $parsedArray = $xmlParser->xmlToArray($simpleXml);
        $this->assertEquals($this->expectedArray(), $parsedArray);
    }

    private function expectedArray(): array
    {
        return [
            'dependencies' => [
                'attributes' => [
                    'generated' => '2021-01-02T13:37:28',
                    'pdepend' => '@package_version@'
                ],
                'package' => [
                    [
                        'attributes' => [
                            'name' => 'PDepend'
                        ],
                        'class' => [
                            [
                                'attributes' => [
                                    'name' => 'Application'
                                ],
                                'efferent' => [
                                    'type' => [
                                        [
                                            'attributes' => [
                                                'namespace' => '',
                                                'name' => 'InvalidArgumentException'
                                            ],
                                            'value' => ''
                                        ],
                                        [
                                            'attributes' => [
                                                'namespace' => 'PDepend\DependencyInjection',
                                                'name' => 'PdependExtension'
                                            ],
                                            'value' => ''
                                        ]
                                    ]
                                ],
                                'afferent' => [
                                    'type' => [
                                        'attributes' => [
                                            'namespace' => 'PDepend\TextUI',
                                            'name' => 'Command'
                                        ],
                                        'value' => ''
                                    ]
                                ],
                                'file' => [
                                    'attributes' => [
                                        'name' => '/var/www/pdepend/src/main/php/PDepend/Application.php'
                                    ],
                                    'value' => ''
                                ]
                            ],
                            [
                                'attributes' => [
                                    'name' => 'Engine'
                                ],
                                'efferent' => [
                                    'type' => [
                                        [
                                            'attributes' => [
                                                'namespace' => 'PDepend\Util',
                                                'name' => 'Configuration'
                                            ],
                                            'value' => ''
                                        ],
                                        [
                                            'attributes' => [
                                                'namespace' => 'PDepend\Util\Cache',
                                                'name' => 'CacheFactory'
                                            ],
                                            'value' => ''
                                        ],
                                        [
                                            'attributes' => [
                                                'namespace' => 'PDepend\Metrics',
                                                'name' => 'AnalyzerFactory'
                                            ],
                                            'value' => ''
                                        ]
                                    ]
                                ],
                                'afferent' => [
                                    'type' => [
                                        'attributes' => [
                                            'namespace' => 'PDepend\TextUI',
                                            'name' => 'Runner'
                                        ],
                                        'value' => ''
                                    ]
                                ],
                                'file' => [
                                    'attributes' => [
                                        'name' => '/var/www/pdepend/src/main/php/PDepend/Engine.php'
                                    ],
                                    'value' => ''
                                ]
                            ]
                        ],
                        'interface' => [
                            'attributes' => [
                                'name' => 'ProcessListener'
                            ],
                            'efferent' => [
                                'type' => [
                                    [
                                        'attributes' => [
                                            'namespace' => 'PDepend\Source\ASTVisitor',
                                            'name' => 'ASTVisitListener'
                                        ],
                                        'value' => ''
                                    ],
                                    [
                                        'attributes' => [
                                            'namespace' => 'PDepend\Metrics',
                                            'name' => 'AnalyzerListener'
                                        ],
                                        'value' => ''
                                    ]
                                ]
                            ],
                            'afferent' => [
                                'type' => [
                                    [
                                        'attributes' => [
                                            'namespace' => 'PDepend',
                                            'name' => 'Engine'
                                        ],
                                        'value' => ''
                                    ],
                                    [
                                        'attributes' => [
                                            'namespace' => 'PDepend\DbusUI',
                                            'name' => 'ResultPrinter'
                                        ],
                                        'value' => ''
                                    ]
                                ]
                            ],
                            'file' => [
                                'attributes' => [
                                    'name' => '/var/www/pdepend/src/main/php/PDepend/ProcessListener.php'
                                ],
                                'value' => ''
                            ]
                        ]
                    ],
                    [
                        'attributes' => [
                            'name' => 'PDepend\DbusUI'
                        ],
                        'class' => [
                            'attributes' => [
                                'name' => 'ResultPrinter'
                            ],
                            'efferent' => [
                                'type' => [
                                    [
                                        'attributes' => [
                                            'namespace' => 'PDepend',
                                            'name' => 'ProcessListener'
                                        ],
                                        'value' => ''
                                    ],
                                    [
                                        'attributes' => [
                                            'namespace' => 'PDepend\Source\ASTVisitor',
                                            'name' => 'AbstractASTVisitListener'
                                        ],
                                        'value' => ''
                                    ],
                                    [
                                        'attributes' => [
                                            'namespace' => '',
                                            'name' => 'DBusDict'
                                        ],
                                        'value' => ''
                                    ]
                                ]
                            ],
                            'afferent' => [
                                'type' => [
                                    'attributes' => [
                                        'namespace' => 'PDepend\TextUI',
                                        'name' => 'Command'
                                    ],
                                    'value' => ''
                                ]
                            ],
                            'file' => [
                                'attributes' => [
                                    'name' => '/var/www/pdepend/src/main/php/PDepend/DbusUI/ResultPrinter.php'
                                ],
                                'value' => ''
                            ]
                        ],
                    ],
                    [
                        'attributes' => [
                            'name' => 'PDepend\DependencyInjection\Compiler'
                        ],
                        'class' => [

                            'attributes' => [
                                'name' => 'ProcessListenerPass'
                            ],
                            'efferent' => [
                                'type' => [
                                    [
                                        'attributes' => [
                                            'namespace' => 'Symfony\Component\DependencyInjection\Compiler',
                                            'name' => 'CompilerPassInterface'
                                        ],
                                        'value' => ''
                                    ],
                                    [
                                        'attributes' => [
                                            'namespace' => 'Symfony\Component\DependencyInjection',
                                            'name' => 'ContainerBuilder'
                                        ],
                                        'value' => ''
                                    ]
                                ]
                            ],
                            'afferent' => [
                                'type' => [
                                    'attributes' => [
                                        'namespace' => 'PDepend',
                                        'name' => 'Application'
                                    ],
                                    'value' => ''
                                ]
                            ],
                            'file' => [
                                'attributes' => [
                                    'name' => '/var/www/pdepend/src/main/php/PDepend/DependencyInjection/Compiler/ProcessListenerPass.php'
                                ],
                                'value' => ''
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }
}