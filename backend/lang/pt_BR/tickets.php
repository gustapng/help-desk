<?php

declare(strict_types=1);

return [
    'types' => [
        'technical_problem'      => 'Problema Técnico',
        'service_request'        => 'Solicitação de Serviço',
        'question_support'       => 'Dúvida / Suporte',
        'improvement_suggestion' => 'Melhoria / Sugestã',
        'security_incident'      => 'Incidente de Segurança',
        'other'                  => 'Outro'

    ],

    'priorities' => [
        'low'    => 'Baixa',
        'medium' => 'Média',
        'high'   => 'Alta',
    ],

    'statuses' => [
        'open'        => 'Aberto',
        'in_progress' => 'Em Andamento',
        'closed'      => 'Fechado',
    ],
];