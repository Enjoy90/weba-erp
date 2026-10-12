<?php

return [
    'actions' => [
        'excel' => 'Export to Excel',
        'pdf'   => 'Export to PDF',
    ],

    'pdf' => [
        'empty'   => 'No rows in this report',
        'printed' => 'Printed by :user on :date',
    ],

    'ranking' => [
        'title'    => 'SAW priority ranking',
        'rank'     => 'Rank',
        'order'    => 'Production order',
        'product'  => 'Product',
        'deadline' => 'Deadline',
        'score'    => 'SAW score',
        'weights'  => 'Weights',
    ],

    'monitoring' => [
        'title'        => 'Order monitoring',
        'order'        => 'Production order',
        'product'      => 'Product',
        'state'        => 'Status',
        'priority'     => 'Priority',
        'deadline'     => 'Deadline',
        'progress'     => 'Progress (%)',
        'material'     => 'Materials (%)',
        'work-left'    => 'Work left (hours)',
        'urgency'      => 'Urgency',
        'order-value'  => 'Order value (Rp)',
        'value-source' => 'Value from',
        'customer'     => 'Customer',
        'source'       => [
            'sales_order' => 'Sales order',
            'manual'      => 'Entered by hand',
        ],
    ],

    'daily' => [
        'period' => 'Period: :from to :until',
    ],
];
