<?php

return [
    'navigation' => [
        'title' => 'Daily Work Panel',
    ],

    'greeting' => [
        'morning'   => 'Good morning, :name',
        'afternoon' => 'Good afternoon, :name',
        'evening'   => 'Good evening, :name',
        'night'     => 'Good evening, :name',
    ],

    'summary' => ':date. Late orders: :late. Due within :days days: :due_soon.',

    'tasks' => [
        'heading' => 'What needs doing today',

        'late' => [
            'title'       => 'Deal with late orders',
            'description' => 'The deadline has passed. Consider overtime or tell the customer.',
            'empty'       => 'No late orders.',
            'button'      => 'View late orders',
        ],

        'plan' => [
            'title'           => "Apply today's priorities",
            'none'            => 'There is no SAW result yet. Run SAW to get a priority ranking.',
            'pending'         => 'The SAW result ":name" is ready. Make the top :count orders Urgent.',
            'applied'         => 'Applied by :user on :date for the top :count orders.',
            'applied-unknown' => 'Applied on :date for the top :count orders.',
            'apply'           => 'Review and apply',
            'run'             => 'Run SAW',
        ],

        'material' => [
            'title'       => 'Complete the raw materials',
            'description' => 'These orders have not received all their materials.',
            'largest'     => 'Largest shortage: :product (:quantity :unit).',
            'empty'       => 'All raw materials of the active orders are available.',
            'button'      => 'Create a purchase request',
        ],

        'more' => 'and :count more',
    ],

    'stats' => [
        'heading' => 'Figures today',

        'active' => [
            'label' => 'Active orders',
            'unit'  => 'orders',
            'help'  => 'Orders that are confirmed, in progress, or ready to close.',
        ],
        'due-soon' => [
            'label' => 'Due in :days days',
            'unit'  => 'orders',
            'help'  => 'Deadline within the next :days days, not counting orders that are already late.',
        ],
        'progress' => [
            'label' => 'Average progress',
            'unit'  => '',
            'help'  => 'Average percentage of finished work over the active orders.',
        ],
        'workload' => [
            'label' => 'Remaining workload',
            'unit'  => 'hours',
            'help'  => 'Total hours of work not yet done across all work centers.',
        ],
        'help-button' => 'Explain :label',
    ],

    'tabs' => [
        'priority'     => 'Priority ranking',
        'work-centers' => 'Work center load',
        'status'       => 'Order status',
    ],

    'priority' => [
        'filter' => [
            'label'     => 'Filter orders',
            'all'       => 'All',
            'attention' => 'Needs attention',
            'progress'  => 'In progress',
        ],
        'score-help' => 'The SAW score runs from 0 to 1 and is calculated from weighted criteria. The higher, the sooner the order should be done.',
        'columns'    => [
            'rank'     => 'Priority',
            'order'    => 'Order',
            'state'    => 'Status',
            'deadline' => 'Deadline',
            'progress' => 'Progress',
            'score'    => 'Score',
        ],
        'open'           => 'Open',
        'progress-label' => 'Progress of order :order',
        'empty'          => 'No SAW result yet',
        'empty-text'     => 'Run SAW to get a priority ranking.',
        'empty-filter'   => 'No order matches this filter.',
    ],

    'work-centers' => [
        'caption'     => 'Hours of work left on the active orders, per work center',
        'hours'       => ':hours hours',
        'work-center' => 'Work center',
        'waiting'     => 'Waiting',
        'running'     => 'Running',
        'orders'      => ':count orders',
        'empty'       => 'No work is left at any work center.',
    ],

    'status' => [
        'caption' => 'Spread of :count orders by stage',
        'empty'   => 'There are no orders yet.',
    ],

    'footer' => [
        'evaluation' => 'Latest evaluation: :name, :date',
        'none'       => 'There is no SAW evaluation yet.',
        'open'       => 'Open the full priority page',
    ],
];
