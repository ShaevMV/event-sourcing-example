<?php

declare(strict_types=1);

namespace OrganizationalFees\Domain\Festival\Model;

use OrganizationalFees\Domain\Festival\Event\FestivalWasCreating;
use OrganizationalFees\Domain\Festival\Event\FestivalWasDelete;
use OrganizationalFees\Domain\Festival\Event\FestivalWasEdit;
use Shared\Domain\Aggregate\Aggregate;
use Shared\Domain\Aggregate\AggregateEventable;
use Shared\Domain\Aggregate\AggregateReconstructable;
use Shared\Domain\Aggregate\AggregateRoot;

class Festival extends AggregateRoot implements Aggregate, AggregateEventable, AggregateReconstructable
{
    private FestivalName $name;
    private FestivalDateStartImmutable $dateStart;
    private FestivalDateEndImmutable $dateEnd;
    private FestivalMailTemplate $mailTemplate;
    private FestivalPdfTemplate $pdfTemplate;

    public static function create(
        string $name,
        \DateTimeImmutable $dateStart,
        \DateTimeImmutable $dateEnd,
        string $pdfTemplate,
        string $mailTemplate,
    ): self {
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

        $this->dateStart = new FestivalDateStartImmutable($festivalWasCreating->dateStart);
        $this->dateEnd = new FestivalDateEndImmutable($festivalWasCreating->dateEnd);

        $this->mailTemplate = FestivalMailTemplate::fromString($festivalWasCreating->mailTemplate);
        $this->pdfTemplate = FestivalPdfTemplate::fromString($festivalWasCreating->pdfTemplate);
    }

    public function edit(
        string $name,
        \DateTimeImmutable $dateStart,
        \DateTimeImmutable $dateEnd,
        string $pdfTemplate,
        string $mailTemplate,
    ): self {
        $this->recordAndApply(new FestivalWasEdit(
            $this->id->value(),
            $name,
            $dateStart,
            $dateEnd,
            $pdfTemplate,
            $mailTemplate
        ));

        return $this;
    }

    public function onFestivalWasEdit(FestivalWasEdit $festivalWasEdit): void
    {
        $this->name = FestivalName::fromString($festivalWasEdit->name);

        $this->dateStart = new FestivalDateStartImmutable($festivalWasEdit->dateStart);
        $this->dateEnd = new FestivalDateEndImmutable($festivalWasEdit->dateEnd);

        $this->mailTemplate = FestivalMailTemplate::fromString($festivalWasEdit->mailTemplate);
        $this->pdfTemplate = FestivalPdfTemplate::fromString($festivalWasEdit->pdfTemplate);
    }

    public function delete(): void
    {
        $this->recordAndApply(new FestivalWasDelete($this->id->value()));
    }
}
