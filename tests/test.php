<?php

use Usman\N8n\N8nClient;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createMutable(__DIR__ . '/..', '.env.test');
$dotenv->safeLoad();

// Raw Testing :)
// Write usage code here and test it by running  through the php command

N8nClient::connect(
    apiBaseUrl: $_ENV['N8N_API_BASE_URL'],
    apiKey: $_ENV['N8N_API_KEY'],
);


//$audit = N8nClient::workflows()->updateWorkflow("N0MN46RQVx9Dlg3C", [
//    'name' => 'Updated Workflow Name',
//    'connections' => [
//        'When clicking ‘Execute workflow’' => [
//            'main' => [
//                [
//                    [
//                        'node' => 'Get many rows',
//                        'type' => 'main',
//                        'index' => 0
//                    ]
//                ]
//            ]
//        ]
//    ],
//    'nodes' => [
//        [
//            'id' => '7e268a44-281d-4de8-9960-831a77deb044',
//            'name' => 'AI Agent',
//            'type' => '@n8n/n8n-nodes-langchain.agent',
//            'typeVersion' => 2.2,
//            'position' => [-208, -480],
//            'parameters' => [
//                'promptType' => 'define',
//                'text' => "=Generate a single tweet based directly on this topic:\n\n{{ a.topic }}\n\nGuidelines:\n- Voice: Anya Grace, 27-year-old Alaskan woman\n- Tone: flat, simple, human, approachable, casual, sometimes absurd, sometimes one-word, not poetic, not hypey\n- Length: under 280 characters, 1-2 sentences\n- Language: plain English, very simple vocabulary, raw and direct, avoid fancy words or jargon\n- Style: clear, concise, relatable, practical or whimsical but grounded\n- Output: only the tweet text, nothing else, no hashtags, no metadata, no extra commentary\n",
//                'options' => []
//            ],
//            'webhookId' => "ksjudhf",
//        ],
//    ],
//    'settings' => [
//        'saveExecutionProgress' => true
//    ],
//]);

$audit = N8nClient::workflows()->getTags("N0MN46RQVx9Dlg3C");

var_dump($audit);