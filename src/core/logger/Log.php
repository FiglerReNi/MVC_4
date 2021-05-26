<?php

namespace core\logger;
class Log
{
    private string $fileName;
    private string $message;

    public function __construct($fileName, $message)
    {
        $this->fileName = $fileName;
        $this->message = $message;
        $this->createLog();
    }

    private function createLog(): void
    {
        if (!is_dir(LOGPATH)) {
            mkdir(LOGPATH);
        }
        file_put_contents(LOGPATH. $this->fileName, $this->message . PHP_EOL, FILE_APPEND);
    }

}