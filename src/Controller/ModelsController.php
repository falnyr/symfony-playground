<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\FooDTO;
use App\Model\FooRequest;
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

        $req = new FooRequest();
        $req->foo = 'hello';
        $req->bar = 'hi';

        $serializer = new Serializer($normalizers, $encoders);
        $data = $serializer->normalize($req);
        $dto = $serializer->denormalize($data, FooDTO::class);

        dump($dto);

        return new Response();
    }
}
