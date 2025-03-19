<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Log\Logger;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger as Monolog;
use App\Models\LogEntry;

class DatabaseLogHandler extends AbstractProcessingHandler {
    protected function write(array|\Monolog\LogRecord $record): void {
        LogEntry::create([
            'level'   => $record['level_name'],
            'message' => $record['message'],
            'context' => $record['context'],
        ]);
    }
}

class DatabaseLogServiceProvider extends ServiceProvider {
    public function boot(): void {
        $logger = app('log');
        $monolog = $logger->getLogger();
        $monolog->pushHandler(new DatabaseLogHandler(Monolog::DEBUG));
    }
}
