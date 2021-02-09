<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\DestionationOne;
use App\Model\SourceOne;
use App\Model\SourceTwo;
use App\Serializer\SourceNormalizer;
use ReflectionProperty;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PropertyAccess\Exception\UninitializedPropertyException;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ModelsController extends AbstractController
{
    public function test(Request $request)
    {
        $src2 = new SourceTwo();
        $src2->qux = 'howdy';

        $src = new SourceOne();
        $src->nested = $src2;
        $src->bar = 'hi';

        $map = [
            'foo' => 'fooAttribute',
            'nested.qux' => 'nested.quxAttribute',
        ];

        $dest = new DestionationOne();
        $access = PropertyAccess::createPropertyAccessor();
        foreach ($map as $sourceValue => $destinationValue) {
            try {
                $access->setValue($dest, $destinationValue, $access->getValue($src, $sourceValue));
            } catch (UninitializedPropertyException $e) {
                $destValue = explode('.', $destinationValue);
                $property = $destValue[0];
                $reflect = new ReflectionProperty($dest, $property);
                /** @var \ReflectionNamedType $propertyType */
                $propertyType = $reflect->getType()->getName();
                $dest->$property = new $propertyType();
                $access->setValue($dest, $destinationValue, $access->getValue($src, $sourceValue));
            }
        }

        dump($dest);

        return new Response();
    }
}
