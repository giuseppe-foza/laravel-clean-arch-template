<?php
declare(strict_types=1);

namespace App\Shared\Enums;

enum EnvironmentEnum: string {
    const string LOCAL = 'local';
    const string PRODUCTION = 'production';
    const string STAGING = 'staging';
    const string TESTING = 'testing';
}
