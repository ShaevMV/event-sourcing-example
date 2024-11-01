<?php

declare(strict_types=1);

namespace OrganizationalFees\Infrastructure\Http\Controller;

use OrganizationalFees\Application\Command\FestivalCreate\FestivalCreateCommandHandler;
use OrganizationalFees\Application\Query\GetFestivalList\GetFestivalListQuery;
use OrganizationalFees\Application\Query\GetFestivalList\GetFestivalListQueryHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/festival', name: 'festival')]
class FestivalController extends AbstractController
{
    #[Route('/create', name: 'festival_create', methods: 'POST')]
    public function create(Request $request, FestivalCreateCommandHandler $commandHandler): JsonResponse
    {
    }

    #[Route('/getList', name: 'festival_get_list', methods: 'GET')]
    public function getList(Request $request, GetFestivalListQueryHandler $handler): JsonResponse
    {
        return new JsonResponse(
            $handler(new GetFestivalListQuery())
        );
    }
}
