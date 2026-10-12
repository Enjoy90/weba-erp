<?php

namespace Weba\ProductionPriority\Support;

use Webkul\Support\Models\Company;

/**
 * The company details at the top of a printed report, taken from the company
 * record so that the name and address are kept in one place.
 */
final readonly class Letterhead
{
    /**
     * @param  list<string>  $addressLines
     */
    public function __construct(
        public string $name,
        public array $addressLines = [],
        public ?string $contact = null,
    ) {}

    public static function current(): self
    {
        $companyId = current_company_id();

        return self::forCompany($companyId === null ? null : Company::query()->find($companyId));
    }

    public static function forCompany(?Company $company): self
    {
        if ($company === null) {
            return new self((string) config('app.name'));
        }

        return new self(
            $company->name,
            array_values(array_filter([
                $company->street1,
                $company->street2,
                trim(implode(' ', array_filter([$company->zip, $company->city]))),
            ])),
            implode('  |  ', array_filter([
                $company->phone ? 'Tel. '.$company->phone : null,
                $company->email,
            ])) ?: null,
        );
    }
}
