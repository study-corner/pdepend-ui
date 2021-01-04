<?php
declare(strict_types=1);

namespace App\Service;

class XmlClosureParser
{
    public function xmlToArray(\SimpleXMLElement $xml): array
    {
        $parser = function (\SimpleXMLElement $xml, array $collection = []) use (&$parser) {
            $nodes = $xml->children();
            $attributes = $xml->attributes();

            $collection = $this->parseAttributes($attributes, $collection);

            if (!$this->hasNodes($nodes)) {
                $collection['value'] = strval($xml);
                return $collection;
            }

            return $this->parseNodes($nodes, $parser, $collection);
        };

        return [
            $xml->getName() => $parser($xml)
        ];
    }

    private function parseAttributes(\SimpleXMLElement $attributes, array $collection): array
    {
        if (0 !== count($attributes)) {
            foreach ($attributes as $attrName => $attrValue) {
                $collection['attributes'][$attrName] = strval($attrValue);
            }
        }
        return $collection;
    }

    private function hasNodes(\SimpleXMLElement $nodes): bool
    {
        return 0 !== $nodes->count();
    }

    private function parseNodes(\SimpleXMLElement $nodes, \Closure $parser, array $collection): array
    {
        foreach ($nodes as $nodeName => $nodeValue) {
            if (count($nodeValue->xpath('../' . $nodeName)) < 2) {
                $collection[$nodeName] = $parser($nodeValue);
                continue;
            }

            $collection[$nodeName][] = $parser($nodeValue);
        }

        return $collection;
    }
}