<?php

namespace App\Serializer;

use App\Model\SourceOne;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class SourceNormalizer implements ContextAwareNormalizerInterface
{
    private ObjectNormalizer $normalizer;

    public function __construct(ObjectNormalizer $normalizer)
    {
        $this->normalizer = $normalizer;
    }

    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return $data instanceof SourceOne;
    }

    public function normalize($object, string $format = null, array $context = []): bool
    {
        $data = $this->normalizer->normalize($object, $format, $context);
        $data['foobar'] = 'foobaz';

        return $data;
    }
}
