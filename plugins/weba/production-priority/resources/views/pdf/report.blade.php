<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>{{ $report->title }}</title>
    <style>
        @page { margin: 28px 32px; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 9px; color: #1f2937; }
        .letterhead { border-bottom: 2px solid #1f2937; padding-bottom: 8px; margin-bottom: 14px; }
        .letterhead-name { font-size: 16px; font-weight: bold; margin: 0 0 3px; }
        .letterhead-line { margin: 0; color: #4b5563; }
        h1 { font-size: 13px; margin: 0 0 4px; }
        .details { margin: 0 0 10px; color: #4b5563; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #e5e7eb; text-align: left; font-weight: bold; }
        th, td { border: 1px solid #d1d5db; padding: 4px 5px; vertical-align: top; }
        tr:nth-child(even) td { background: #f9fafb; }
        .number { text-align: right; }
        .empty { text-align: center; color: #6b7280; padding: 14px; }
        .footer { margin-top: 12px; color: #6b7280; font-size: 8px; }
    </style>
</head>
<body>
    <div class="letterhead">
        <p class="letterhead-name">{{ $letterhead->name }}</p>
        @foreach ($letterhead->addressLines as $line)
            <p class="letterhead-line">{{ $line }}</p>
        @endforeach
        @if ($letterhead->contact)
            <p class="letterhead-line">{{ $letterhead->contact }}</p>
        @endif
    </div>

    <h1>{{ $report->title }}</h1>
    @foreach ($report->details as $detail)
        <p class="details">{{ $detail }}</p>
    @endforeach

    <table>
        <thead>
            <tr>
                @foreach ($report->headings as $heading)
                    <th>{{ $heading }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse ($report->rows as $row)
                <tr>
                    @foreach ($row as $cell)
                        <td @class(['number' => is_int($cell) || is_float($cell)])>
                            @if (is_float($cell))
                                {{ rtrim(rtrim(number_format($cell, 2, '.', ','), '0'), '.') }}
                            @else
                                {{ $cell }}
                            @endif
                        </td>
                    @endforeach
                </tr>
            @empty
                <tr>
                    <td class="empty" colspan="{{ count($report->headings) }}">{{ __('production-priority::filament/reports.pdf.empty') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <p class="footer">{{ __('production-priority::filament/reports.pdf.printed', ['user' => $printedBy, 'date' => $printedAt]) }}</p>
</body>
</html>
