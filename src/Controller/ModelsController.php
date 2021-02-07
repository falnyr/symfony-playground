<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\DestionationOne;
use App\Model\SourceOne;
use App\Model\SourceTwo;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ModelsController extends AbstractController
{
    public function test(Request $request)
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $src2 = new SourceTwo();
        $src2->qux = 'howdy';

        $src = new SourceOne();
        $src->nested = $src2;
        $src->foo = 'hello';
        $src->bar = 'hi';

        $serializer = new Serializer($normalizers, $encoders);
        $data = $serializer->normalize($src);
        $dest = $serializer->denormalize($data, DestionationOne::class);

        dump($dest);

        return new Response();
    }
}
