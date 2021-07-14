<?php 
declare(strict_types=1);

/**
 * Class CodeGenerator.
 */
class CodeGenerator
{
    private const ALPHABET = '1234567890abcdefghigklmnopqrstuvwxyzABCDEFGHIGKLMNOPQRSTUVWXYZ';
    
    /**
     * @return string
     */
    public function generateCode(int $length = 6): string
    {
        $ret = '';
        $len = strlen(self::ALPHABET);
        $maxIdx = $len - 1;
        for ($i = 0; $i < $length; $i++) {
            $ret .= substr(self::ALPHABET, random_int(0, $maxIdx), 1);
        }
        
        return $ret;
    }
}
