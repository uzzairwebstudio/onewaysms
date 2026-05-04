<?php

namespace Uzzairwebstudio\Onewaysms;



class OneWaySMSManager
{
    public function __construct(
        protected string $apiUsername,
        protected string $apiPassword,
        protected string $mtUrl,
        protected string $checkStatusUrl,
        protected string $checkCreditUrl
    ) {}

    public function send(string $mobileNo, string $message, string $senderId = 'INFO', int $languageType = 1): int|string
    {
        if ($languageType === 2) {
            $message = $this->convertToHex($message);
        }

        $query = http_build_query([
            'apiusername' => $this->apiUsername,
            'apipassword' => $this->apiPassword,
            'mobileno' => $mobileNo,
            'senderid' => $senderId,
            'languagetype' => $languageType,
            'message' => $message,
        ]);

        return file_get_contents($this->mtUrl . '?' . $query);
    }

    public function checkStatus(string $mtId): int|string
    {
        $query = http_build_query([
            'mtid' => $mtId,
        ]);

        return file_get_contents($this->checkStatusUrl . '?' . $query);
    }

    public function checkCredit(): int|string
    {
        $query = http_build_query([
            'apiusername' => $this->apiUsername,
            'apipassword' => $this->apiPassword,
        ]);

        return file_get_contents($this->checkCreditUrl . '?' . $query);
    }

    protected function convertToHex(string $string): string
    {
        $hex = '';
        for ($i = 0; $i < mb_strlen($string, 'UTF-8'); $i++) {
            $char = mb_substr($string, $i, 1, 'UTF-8');
            $hex .= str_pad(dechex(mb_ord($char)), 4, '0', STR_PAD_LEFT);
        }

        return strtoupper($hex);
    }
}
