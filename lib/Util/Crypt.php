<?php
namespace Lib\Util;

/*
 * 简单的加密/解密(AES)算法
 */
class Crypt
{
    private $key = '';
    private $iv = '';
    private $cipher = MCRYPT_RIJNDAEL_256;
    private $mode = MCRYPT_MODE_ECB;

    public function __construct($key)
    {
        $this->key = $key;
        $this->iv = mcrypt_create_iv(mcrypt_get_iv_size($this->cipher,$this->mode));
    }

    public function encrypt($data)
    {
        $result = mcrypt_encrypt($this->cipher, $this->key, $data, $this->mode, $this->iv);
        return bin2hex($result);
    }

    public function decrypt($data)
    {
        $data = hex2bin($data);
        return mcrypt_decrypt($this->cipher, $this->key, $data, $this->mode, $this->iv);
    }
}