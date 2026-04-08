<?php

namespace application\modules\shared\Components;

final class Hasher
{
    private const ENCRYPT_SALT = "3`(<516`]w6'C~sGjB]<^!Dpu[9?6`";
    private const ENCRYPT_ALGORITHM = "AES-256-CBC";
    private const INITIALIZATION_VECTOR = "cdf86fc413278d46";

    public static function getInstance(): self
    {
        return new self();
    }

    public function getEncryptedData(string $plaintext): string
    {
        $saltInMd5 = md5(self::ENCRYPT_SALT);
        $iniVector = $this->getInitialVector();
        return openssl_encrypt(
            $plaintext,
            self::ENCRYPT_ALGORITHM,
            $saltInMd5,
            0,
            $iniVector
        );
    }

    public function getDecryptedData(string $encryptedText): string
    {
        $saltInMd5 = md5(self::ENCRYPT_SALT);
        $iniVector = $this->getInitialVector();
        return openssl_decrypt(
            $encryptedText,
            self::ENCRYPT_ALGORITHM,
            $saltInMd5,
            0,
            $iniVector
        );
    }

    private function getInitialVector(): string
    {
        $iniVector = md5(self::INITIALIZATION_VECTOR);
        return substr($iniVector, 0, 16);
    }

    public function doesPasswordMatch(string $hashedPassword, string $plainPassword): bool
    {
        return sodium_crypto_pwhash_str_verify($hashedPassword, $plainPassword);
    }
}
