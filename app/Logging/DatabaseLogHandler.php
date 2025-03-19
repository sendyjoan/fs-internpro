<?php
namespace App\Logging;

use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;
use App\Models\LogEntry;

class DatabaseLogHandler extends AbstractProcessingHandler {
    public function __construct($level = Logger::DEBUG, bool $bubble = true) {
        parent::__construct($level, $bubble);
    }

    protected function write(array|\Monolog\LogRecord $record): void {
        LogEntry::create([
            'level'   => $record['level_name'],
            'message' => $record['message'],
            'context' => json_encode($record['context']),
            'created_at' => now(),
        ]);
    }
}
