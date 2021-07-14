<?php
declare(strict_types=1);

final class DB
{
    /** @var \PDO */
    private $pdo;

    /**
     * @throws \Exception
     */
    public function __construct()
    {
        $dbSettings = require_once \implode(DIRECTORY_SEPARATOR, [PROJECT_DIR, 'settings', 'db.php']);
        $dsn = ($dbSettings['type'] ?? null) . ':dbname=' . ($dbSettings['dbname'] ?? null) . ';host=' . ($dbSettings['host'] ?? null) . ';port=' . ($dbSettings['port'] ?? null);
        try {
            $this->pdo = new \PDO($dsn, $dbSettings['user'] ?? null, $dbSettings['password'] ?? null);
        } catch (\Throwable $e) {
            throw new \Exception('Can not connect to DB');
        }
    }

    /**
     * @param string $text
     * @return bool
     */
    public function addLink(string $link): string
    {
        if ($data = $this->findLink($link)) {
            return $data['code'];
        }
        
        $generator = $this->getGenerator();
        do {
            $newCode = $generator->generateCode();
        } while ($this->findByCode($newCode));
        
        $sql = 'INSERT INTO `short_links` (`link`, `code`) VALUES (:link, :code);';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam('link', $link);
        $stmt->bindParam('link', $newCode);
        $stmt->execute();
        
        return $newCode;
    }

    /**
     * @param string $code
     * @return array
     */
    public function findByCode(string $code): array
    {
        $sql = 'SELECT * from `short_links` where `code` = :code;';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam('code', $code);
        $stmt->execute();
        
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    /**
     * @param string $link
     * @return array
     */
    protected function findLink(string $link): array
    {
        $sql = 'SELECT * from `short_links` where `link` = :link;';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam('link', $link);
        $stmt->execute();
        
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * @return \CodeGenerator
     */
    protected function getGenerator(): \CodeGenerator
    {
        // TODO: use autoloader here )))
        require_once \implode(DIRECTORY_SEPARATOR, [PROJECT_DIR, 'src', 'CodeGenerator.php']);
        
        return new \CodeGenerator;
    }
}
