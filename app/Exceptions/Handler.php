<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Exception
     */

    //ログインタイムアウトした時にログイン画面に映るための記述
    public function render($request, Throwable $exception) //renderメソッド：呼び出すビューファイルを指定するメソッド
    //Throwable：全ての例外
    {
        if ($exception instanceof TokenMismatchException) {
            //instanceof：左辺が右辺のクラスだったら
            return redirect()->route('login'); //ログインがタイムアウトしたらloginページに遷移
        }
        return parent::render($request, $exception);
    }
}
