<?php

declare(strict_types=1);

namespace ArrangementFee\Application\Query\GetOrderList;

use ArrangementFee\Application\Model\OrderRepositoryInterface;
use Shared\Domain\Bus\Query\QueryHandler;

class GetOrderListQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly OrderRepositoryInterface $arrangementFeeRepository
    )
    {
    }

    public function __invoke(GetOrderListQuery $query): GetOrderListQueryResponse
    {
        $orderList = $this->arrangementFeeRepository->getOrderList();

        return new GetOrderListQueryResponse($orderList);
    }
}