<?php

namespace App\Controller;

use App\Service\DependenciesParser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DependenciesController extends AbstractController
{
    /**
     * @Route("/dependencies", name="dependencies")
     */
    public function index(): Response
    {
        $dependenciesParser = new DependenciesParser();
        $dependenciesParser->parse($this->getXml());
        $dependencies = $dependenciesParser->getDependencies();
        $dependencies->calculateStability();

        return $this->render('dependencies/index.html.twig', [
            'dependencies' => $dependencies,
        ]);
    }

    private function getXml(): \SimpleXMLElement
    {
        $dir = realpath(__DIR__ . '/../../build/mlt');
        $xmlFile = $dir . '/dependencies.xml';

        return simplexml_load_file($xmlFile);
    }
}
