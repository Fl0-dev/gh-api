<?php

namespace App\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Platform;
use App\Service\ImageDownloader;
use Symfony\Component\HttpFoundation\RequestStack;

final class PlatformProcessor implements ProcessorInterface
{
    private ImageDownloader $imageDownloader;
    private RequestStack $requestStack;

    public function __construct(ImageDownloader $imageDownloader, RequestStack $requestStack)
    {
        $this->imageDownloader = $imageDownloader;
        $this->requestStack = $requestStack;
    }

    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        var_dump($data);
        $request = $this->requestStack->getCurrentRequest();
        if ($request && $request->getMethod() === 'POST' && $data instanceof Platform) {
            $logoUrl = $request->request->get('logoPath');
            if ($logoUrl) {
                $filename = $this->imageDownloader->downloadImage($logoUrl);
                if ($filename) {
                    $data->setLogoPath('/images/logos/' . $filename);
                }
            }
        }
    }

    public function supports($data, Operation $operation, array $uriVariables = [], array $context = []): bool
    {
        return $data instanceof Platform;
    }
}
