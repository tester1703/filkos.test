<?php
declare(strict_types=1);

/**
 * Class App.
 */
class App
{
    /**
     * @return string
     */
    public function init(): string
    {
        \header('Content-Type: application/json');
        $resp = [
            'success' => false,
        ];

        $link = $_POST['link'] ?? null;
        if (!\is_scalar($link) || empty($link = \trim($link))) {
            return $this->getResponse($resp);
        }

        try {
            $db = $this->getDb();
        } catch (\Throwable $e) {
            return $this->getResponse($resp);
        }
        
        if (!$this->validateLink($link)) {
            return $this->getResponse($resp);
        }

        $code = $db->addLink($link);
        $resp['success'] = true;
        $resp['code'] = $code;

        return $this->getResponse($resp);
    }
    
    /**
     * Process POST
     */
    public function code(): void
    {
        $code = $_GET['code'] ?? null;
        if (!is_scalar($code)) {
            \header('HTTP/1.1 400 Bad Request');
            
            return;
        }
        
        $code = \trim($code);
        if (!$code) {
            \header('HTTP/1.1 400 Bad Request');
            
            return;
        }
        
        try {
            $db = $this->getDb();
        } catch (\Throwable $e) {
            \header('HTTP/1.1 500 Internal Server Error');
            
            return;
        }
        
        if ($data = $this->findLink($link)) {
            \header(sprintf('Location: %s', $data['link']));

            return;
        }

        \header('HTTP/1.1 400 Bad Request');

        return;
    }

    /**
     * @param string $link
     * @return bool
     */
    protected function validateLink(string $link): bool
    {
        return ($parsedUrl['scheme'] ?? false) && ($parsedUrl['host'] ?? false);
    }
    
    /**
     * @param array $data
     * @return string
     */
    protected function getResponse(array $data): string
    {
        return \json_encode($data);
    }

    /**
     * @return \DB
     */
    protected function getDb(): \DB
    {
        // TODO: use autoloader here )))
        require_once \implode(DIRECTORY_SEPARATOR, [PROJECT_DIR, 'src', 'DB.php']);

        return new \DB;
    }
}
