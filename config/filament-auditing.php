<?php

use App\Models\User;

return [

    'audits_sort' => [
        'column' => 'created_at',
        'direction' => 'desc',
    ],
 
    'is_lazy' => true,
 
    'audits_extend' => [
        // 'url' => [
        //     'class' => \Filament\Tables\Columns\TextColumn::class,
        //     'methods' => [
        //         'sortable',
        //         'searchable' => true,
        //         'default' => 'N/A'
        //     ]
        // ],
    ],
 
    'custom_audits_view' => false,
 
    'custom_view_parameters' => [
    ],
 
    'mapping' => [
        'user_id' => [
            'model' => User::class,
            'field' => 'username',
            'label' => 'User',
        ],
    ],
];
