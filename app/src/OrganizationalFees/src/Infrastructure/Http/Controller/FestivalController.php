<?php

declare(strict_types=1);

namespace OrganizationalFees\Infrastructure\Http\Controller;

use OrganizationalFees\Application\Command\FestivalCreate\FestivalCreateCommandHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/festival', name: 'festival')]
class FestivalController  extends AbstractController
{
    #[Route('/festival/create', name: 'festival', methods: 'POST')]
    public function create(Request $request, FestivalCreateCommandHandler $handler): Response
    {

    }
}