<?php

declare(strict_types=1);

namespace OrganizationalFees\Domain\Festival\Model;

use DateTime;
use OrganizationalFees\Domain\Festival\Event\FestivalWasCreating;
use Shared\Domain\Aggregate\Aggregate;
use Shared\Domain\Aggregate\AggregateEventable;
use Shared\Domain\Aggregate\AggregateReconstructable;
use Shared\Domain\Aggregate\AggregateRoot;

class Festival extends AggregateRoot implements Aggregate, AggregateEventable, AggregateReconstructable
{
    private FestivalName $name;
    private FestivalDateStart $dateStart;
    private FestivalDateEnd $dateEnd;
    private FestivalMailTemplate $mailTemplate;
    private FestivalPdfTemplate $pdfTemplate;

    public static function create(
        string   $name,
        DateTime $dateStart,
        DateTime $dateEnd,
        string   $pdfTemplate,
        string   $mailTemplate,
    ): self
    {
        $arrangementFee = new self(FestivalId::random());

        $arrangementFee->recordAndApply(new FestivalWasCreating(
            $arrangementFee->id()->value(),
            $name,
            $dateStart,
            $dateEnd,
            $pdfTemplate,
            $mailTemplate
        ));

        return $arrangementFee;
    }

    public function onFestivalWasCreating(FestivalWasCreating $festivalWasCreating): void
    {
        $this->id = FestivalId::fromString($festivalWasCreating->getAggregateId());
        $this->name = FestivalName::fromString($festivalWasCreating->name);

        $this->dateStart = new FestivalDateStart($festivalWasCreating->dateStart);
        $this->dateEnd = new FestivalDateEnd($festivalWasCreating->dateEnd);

        $this->mailTemplate = FestivalMailTemplate::fromString($festivalWasCreating->mailTemplate);
        $this->pdfTemplate = FestivalPdfTemplate::fromString($festivalWasCreating->pdfTemplate);
    }
}