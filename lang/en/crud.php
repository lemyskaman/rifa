<?php

return [
    'common' => [
        'actions' => 'Actions',
        'create' => 'Create',
        'edit' => 'Edit',
        'update' => 'Update',
        'new' => 'New',
        'cancel' => 'Cancel',
        'attach' => 'Attach',
        'detach' => 'Detach',
        'save' => 'Save',
        'delete' => 'Delete',
        'delete_selected' => 'Delete selected',
        'search' => 'Search...',
        'back' => 'Back to Index',
        'are_you_sure' => 'Are you sure?',
        'no_items_found' => 'No items found',
        'created' => 'Successfully created',
        'saved' => 'Saved successfully',
        'removed' => 'Successfully removed',
    ],

    'users' => [
        'name' => 'Users',
        'index_title' => 'Users List',
        'new_title' => 'New User',
        'create_title' => 'Create User',
        'edit_title' => 'Edit User',
        'show_title' => 'Show User',
        'inputs' => [
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
        ],
    ],

    'user_tickets' => [
        'name' => 'User Tickets',
        'index_title' => 'Tickets List',
        'new_title' => 'New Ticket',
        'create_title' => 'Create Ticket',
        'edit_title' => 'Edit Ticket',
        'show_title' => 'Show Ticket',
        'inputs' => [
            'payment_status' => 'Payment Status',
            'amount' => 'Amount',
        ],
    ],

    'tickets' => [
        'name' => 'Tickets',
        'index_title' => 'Tickets List',
        'new_title' => 'New Ticket',
        'create_title' => 'Create Ticket',
        'edit_title' => 'Edit Ticket',
        'show_title' => 'Show Ticket',
        'inputs' => [
            'user_id' => 'Usuario',
            'payment_status' => 'Estado de Pago',
            'amount' => 'Amount',
        ],
    ],

    'ticket_terminals' => [
        'name' => 'Ticket Terminals',
        'index_title' => 'Terminals List',
        'new_title' => 'New Terminal',
        'create_title' => 'Create Terminal',
        'edit_title' => 'Edit Terminal',
        'show_title' => 'Show Terminal',
        'inputs' => [
            'number' => 'Number',
            'status' => 'Status',
        ],
    ],

    'ticket_payments' => [
        'name' => 'Ticket Payments',
        'index_title' => 'Payments List',
        'new_title' => 'New Payment',
        'create_title' => 'Create Payment',
        'edit_title' => 'Edit Payment',
        'show_title' => 'Show Payment',
        'inputs' => [
            'id' => 'Id',
            'amount' => 'Amount',
            'status' => 'Status',
        ],
    ],

    'payments' => [
        'name' => 'Payments',
        'index_title' => 'Payments List',
        'new_title' => 'New Payment',
        'create_title' => 'Create Payment',
        'edit_title' => 'Edit Payment',
        'show_title' => 'Show Payment',
        'inputs' => [
            'ticket_id' => 'Ticket',
            'amount' => 'Amount',
            'status' => 'Status',
        ],
    ],

    'terminals' => [
        'name' => 'Terminals',
        'index_title' => 'Terminals List',
        'new_title' => 'New Terminal',
        'create_title' => 'Create Terminal',
        'edit_title' => 'Edit Terminal',
        'show_title' => 'Show Terminal',
        'inputs' => [
            'raffle_id' => 'Raffle',
            'number' => 'Number',
            'price' => 'Price',
            'status' => 'Status',
            'ticket_id' => 'Ticket',
        ],
    ],

    'raffles' => [
        'name' => 'Raffles',
        'index_title' => 'Raffles List',
        'new_title' => 'New Raffle',
        'create_title' => 'Create Raffle',
        'edit_title' => 'Edit Raffle',
        'show_title' => 'Show Raffle',
        'inputs' => [
            'name' => 'Name',
            'date' => 'Fecha de Sorteo',
        ],
    ],

    'raffle_terminals' => [
        'name' => 'Raffle Terminals',
        'index_title' => 'Terminals List',
        'new_title' => 'New Terminal',
        'create_title' => 'Create Terminal',
        'edit_title' => 'Edit Terminal',
        'show_title' => 'Show Terminal',
        'inputs' => [
            'number' => 'Number',
            'status' => 'Status',
            'price' => 'Price',
        ],
    ],

    'roles' => [
        'name' => 'Roles',
        'index_title' => 'Roles List',
        'create_title' => 'Create Role',
        'edit_title' => 'Edit Role',
        'show_title' => 'Show Role',
        'inputs' => [
            'name' => 'Name',
        ],
    ],

    'permissions' => [
        'name' => 'Permissions',
        'index_title' => 'Permissions List',
        'create_title' => 'Create Permission',
        'edit_title' => 'Edit Permission',
        'show_title' => 'Show Permission',
        'inputs' => [
            'name' => 'Name',
        ],
    ],
];
