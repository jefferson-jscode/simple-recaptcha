<?php

namespace Recaptcha;

class ReCaptcha
{
    private string $siteKey;
    private string $secretKey;
    private string $formId;
    private int $version;

    private const RECAPTCHA_API_URL = 'https://www.google.com/recaptcha/api/siteverify';

    public function __construct($siteKey, $secretKey, $formId, $version = 3)
    {
        $this->siteKey = $siteKey;
        $this->secretKey = $secretKey;
        $this->formId = $formId;
        $this->version = $version;
    }

    /**
     * Include reCaptcha's API script and verification function.
     * @return void
     */
    public function script(): void
    {
        echo '<script src="https://www.google.com/recaptcha/api.js"></script>';
        echo '<script> function onSubmit(token) { document.getElementById("' . $this->formId . '").submit(); } </script>';
    }

    /**
     * Display reCaptcha's checkbox.
     * @return void
     */
    public function checkbox()
    {
        if ($this->version != 2) {
            return;
        }

        echo '<div class="g-recaptcha mb-3" data-sitekey="' . $this->siteKey . '"></div>';
    }

    /**
     * Display the class to be used in the submit button.
     * @return void
     */
    public function buttonClass(): void
    {
        if ($this->version != 3) {
            return;
        }

        echo 'g-recaptcha';
    }

    /**
     * Display the attributes to be used in the submit button.
     * @return void
     */
    public function buttonAttributes(): void
    {
        if ($this->version != 3) {
            return;
        }

        echo 'data-sitekey="' . $this->siteKey . '" data-callback="onSubmit" data-action="submit"';
    }

    public function verify($parameters): bool
    {
        return $this->verifyResponse($parameters['g-recaptcha-response']);
    }

    public function verifyResponse(string $response): bool
    {
        $params = array('secret' => $this->secretKey, 'response' => $response, 'remoteip' => $_SERVER['REMOTE_ADDR']);
        $defaults = array(
            CURLOPT_URL => self::RECAPTCHA_API_URL,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($params),
            CURLOPT_RETURNTRANSFER => true
        );

        $ch = curl_init();
        curl_setopt_array($ch, $defaults);

        $response = curl_exec($ch);
        $json_response = json_decode($response);

        if (curl_error($ch) || !$json_response->success)
        {
            return false;
        }

        curl_close($ch);

        return true;
    }

}
