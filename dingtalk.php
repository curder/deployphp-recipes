<?php

namespace Deployer;

use Deployer\Utility\Httpie;

// Title of project

set('dingtalk_title', function () {
    return get('application', 'Project');
});

// Webhook
set('dingtalk_webhook', function () {
    return 'https://oapi.dingtalk.com/robot/send?access_token=' . get('dingtalk_access_token');
});

// Deploy message
set('dingtalk_text', '_{{user}}_ deploying `{{branch}}` to *{{target}}*');
set('dingtalk_success_text', 'Deploy to *{{target}}* successful');
set('dingtalk_failure_text', 'Deploy to *{{target}}* failed');

desc('Notifying DingTalk');
task('dingtalk:notify', function () {
    if (!get('dingtalk_access_token', false)) {
        return;
    }
    $body = [
        'msgtype' => 'markdown',
        'markdown' => [
            'title' => get('dingtalk_title'),
            'text' => get('dingtalk_text') . sprintf(" \n\n\n > %s", date('Y-m-d H:i:s')),
        ],
        'isAtAll' => true,
    ];
    Httpie::post(get('dingtalk_webhook'))->body($body)->send();
})
    ->once()
    ->shallow()
    ->setPrivate();

desc('Notifying DingTalk about deploy finish');
task('dingtalk:notify:success', function () {
    if (!get('dingtalk_access_token', false)) {
        return;
    }
    $body = [
        'msgtype' => 'markdown',
        'markdown' => [
            'title' => get('dingtalk_title'),
            'text' => get('dingtalk_success_text') . sprintf(" \n\n\n > %s", date('Y-m-d H:i:s')),
        ],
        'isAtAll' => true,
    ];
    Httpie::post(get('dingtalk_webhook'))->body($body)->send();
})
    ->once()
    ->shallow()
    ->setPrivate();

desc('Notifying DingTalk about deploy failure');
task('dingtalk:notify:failure', function () {
    if (!get('dingtalk_access_token', false)) {
        return;
    }
    $body = [
        'msgtype' => 'markdown',
        'markdown' => [
            'title' => get('dingtalk_title'),
            'text' => get('dingtalk_failure_text') . sprintf(" \n\n\n > %s", date('Y-m-d H:i:s')),
        ],
        'isAtAll' => true,
    ];
    Httpie::post(get('dingtalk_webhook'))->body($body)->send();
})
    ->once()
    ->shallow()
    ->setPrivate();
