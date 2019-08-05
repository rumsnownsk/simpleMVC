<?php

ini_set('display_errors', 1);

define("DEBUG", true); //  true - Режим разработки

class NotFoundException extends Exception
{
    public function __construct($message = "", $code = 404, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

class ErrorHandler
{
    public function __construct()
    {
        if (DEBUG) {
            error_reporting(-1);
        } else {
            error_reporting(0);
        }

        set_error_handler([$this, 'myErrorHandler']);

        ob_start();
        register_shutdown_function([$this, 'fatalErrorHandler']);
        set_exception_handler([$this, 'exceptionHandler']);
    }


    // Обработка ошибок типа Notice или Warning
    public function myErrorHandler($errno, $errstr, $errfile, $errline)
    {
        $this->makeLogs($errstr, $errfile, $errline);

        $this->myDisplayError($errno, $errstr, $errfile, $errline);

        return true;
    }


    // Обработка ошибок типа Fatal Error
    public function fatalErrorHandler()
    {
        $error = error_get_last();  //

        if (!empty($error) && $error['type'] & (E_ERROR | E_PARSE | E_COMPILE_ERROR | E_CORE_ERROR)) {

            ob_end_clean();

            $this->makeLogs($error['message'], $error['file'], $error['line']);
            $this->myDisplayError($error['type'], $error['message'], $error['file'], $error['line']);

        } else {
            ob_end_flush();
        }
    }


    // Обработка ошибок типа Exception
    public function exceptionHandler($e)
    {
        $this->makeLogs($e->getMessage(), $e->getFile(), $e->getLine());

        $this->myDisplayError('', $e->getMessage(), $e->getFile(), $e->getLine(), $e->getCode());
    }


    protected function myDisplayError($errno, $errstr, $errfile, $errline, $response = 500)
    {
        http_response_code($response);
        if (DEBUG) {
            require_once '/var/www/simplemvc.ru/app/views/errors/dev.php';
        } else {
            require_once '/var/www/simplemvc.ru/app/views/errors/prod.php';
        }
        die;
    }


    public function makeLogs($errstr, $errfile, $errline)
    {
        error_log("[" . date('Y-m-d H:i:s') . "]; Текст: {$errstr} | Файл: {$errfile} | Строка: {$errline} \n=======================\n",
            3,
            __DIR__ . "/errors.log");
    }

}

new ErrorHandler();
//throw new NotFoundException('Uups, except!!! )))', 404);
try{
    if(empty($test)){
        throw new Exception('Uups, except!!! )))');
    }
}
catch (Exception $e){
    var_dump($e);
};


//test();             // fatal error

//echo $phpinfo;      // Notice error