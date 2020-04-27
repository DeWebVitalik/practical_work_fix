<?php


namespace App\Exceptions;


use Illuminate\Http\Request;

class ServiceException extends \Exception
{

    private string $userMessage;

    public function __construct(string $userMessage)
    {
        $this->userMessage = $userMessage;
        parent::__construct("Service exception");
    }

    public function getUserMessage(): string
    {
        return $this->userMessage;
    }

    /**
     * Render an exception into an HTTP response
     *
     * @param $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function render(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $json = [
                'success' => false,
                'error' => $this->getUserMessage(),
            ];

            return response()->json($json, 400);
        } else {
            return redirect()->back()
                ->with('error', trans($this->getUserMessage()));
        }
    }
}
