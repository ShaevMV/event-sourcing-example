<?php

declare(strict_types=1);

namespace OrganizationalFees\Infrastructure\Http\Controller;

use OrganizationalFees\Application\Command\Festival\FestivalCreate\FestivalCreateCommand;
use OrganizationalFees\Application\Command\Festival\FestivalCreate\FestivalCreateCommandHandler;
use OrganizationalFees\Application\Query\Festival\GetFestivalList\GetFestivalListQuery;
use OrganizationalFees\Application\Query\Festival\GetFestivalList\GetFestivalListQueryHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/festival', name: 'festival')]
class FestivalController extends AbstractController
{
    public function __construct(
        private readonly ValidatorInterface $validator,
    ) {
    }

    /**
     * @throws \DateMalformedStringException
     */
    #[Route('/create', name: 'festival_create', methods: 'POST')]
    public function create(Request $request, FestivalCreateCommandHandler $commandHandler): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

            $command = new FestivalCreateCommand(
                $data['name'],
                $data['dateStart'],
                $data['dateEnd'],
                $data['mailTemplate'],
                $data['pdfTemplate'],
            );
        } catch (\Throwable $exception) {
            return new JsonResponse([
                'success' => false,
                'errors' => [$exception->getMessage()],
            ]);
        }

        $errors = $this->validator->validate($command);
        $errorArray = [];

        foreach ($errors as $error) {
            $errorArray[$error->getPropertyPath()] = $error->getMessage();
        }

        if ($errors->count() > 0) {
            return new JsonResponse([
                'success' => false,
                'errors' => $errorArray,
            ]);
        }

        $response = $commandHandler($command);

        return new JsonResponse($response);
    }

    #[Route('/getList', name: 'festival_get_list', methods: 'GET')]
    public function getList(Request $request, GetFestivalListQueryHandler $handler): JsonResponse
    {
        return new JsonResponse(
            $handler(new GetFestivalListQuery())
        );
    }

    #[Route('/find', name: 'festival_find', methods: 'GET')]
    public function find(Request $request, GetFestivalListQueryHandler $handler): JsonResponse
    {
        return new JsonResponse(
            $handler(new GetFestivalListQuery())
        );
    }
}
