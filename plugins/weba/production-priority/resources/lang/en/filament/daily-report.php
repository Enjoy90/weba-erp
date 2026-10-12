<?php

return [
    'navigation' => [
        'title' => 'Daily production report',
    ],

    'subheading' => 'Work orders worked on or finished in the period, planned against achieved. Quantity and minutes are the totals of each work order to date; the last column counts only the minutes logged inside the period.',

    'table' => [
        'order'             => 'Production order',
        'product'           => 'Product',
        'operation'         => 'Operation',
        'work-center'       => 'Work center',
        'state'             => 'Status',
        'target-quantity'   => 'Order quantity',
        'produced-quantity' => 'Produced',
        'planned-minutes'   => 'Planned (min)',
        'actual-minutes'    => 'Actual (min)',
        'efficiency'        => 'Efficiency',
        'minutes-in-period' => 'Worked in period (min)',
        'period'            => 'Period',
        'from'              => 'From',
        'until'             => 'Until',
        'total'             => 'Total',
        'total-finished'    => 'Total of finished',
        'empty'             => 'No work was logged in this period',
        'empty-description' => 'Choose another date, or clear the period filter to see every work order.',
    ],

    'indicators' => [
        'from'  => 'From :date',
        'until' => 'Until :date',
    ],
];
