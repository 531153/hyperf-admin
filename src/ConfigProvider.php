<?php
declare(strict_types=1);
namespace Mzh\Admin;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'commands' => [
            ],
            'annotations' => [
                'scan' => [
                    'paths' => [
                        __DIR__
                    ],
                ],
            ],
            'publish' => [
                [
                    'id' => 'admin',
                    'description' => 'hyperf-admin',
                    'source' => __DIR__ . '/../publish/admin.php',
                    'destination' => BASE_PATH . '/config/autoload/admin.php',
                ],
            ],
        ];
    }
}
