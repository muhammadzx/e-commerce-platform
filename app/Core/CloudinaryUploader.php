<?php

class CloudinaryUploader
{
    private array $config;

    public function __construct()
    {
        $this->config = require __DIR__ . '/../../config/cloudinary.php';
    }

    public function uploadImage($file)
    {
        if (!isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
            throw new RuntimeException('Image upload failed.');
        }

        if ($file['size'] > 5 * 1024 * 1024) {
            throw new RuntimeException('Image must be smaller than 5 MB.');
        }

        if (!is_uploaded_file($file['tmp_name'])) {
            throw new RuntimeException('Invalid uploaded file.');
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($file['tmp_name']);
        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];

        if (!in_array($mime, $allowedTypes, true)) {
            throw new RuntimeException('Only JPG, PNG and WebP images are allowed.');
        }

        $cloudName = $this->config['cloud_name'] ?? '';
        $apiKey = $this->config['api_key'] ?? '';
        $apiSecret = $this->config['api_secret'] ?? '';

        if ($cloudName === '' || $apiKey === '' || $apiSecret === '') {
            throw new RuntimeException('Cloudinary configuration is missing.');
        }

        $timestamp = time();
        $folder = 'nabta/products';
        $signature = sha1("folder={$folder}&timestamp={$timestamp}{$apiSecret}");
        $url = 'https://api.cloudinary.com/v1_1/' . rawurlencode($cloudName) . '/image/upload';

        $postData = [
            'file' => new CURLFile($file['tmp_name'], $mime, basename($file['name'])),
            'api_key' => $apiKey,
            'timestamp' => $timestamp,
            'folder' => $folder,
            'signature' => $signature
        ];

        $curl = curl_init($url);
        curl_setopt_array($curl, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT => 30
        ]);

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $curlError = curl_error($curl);
        curl_close($curl);

        if ($response === false) {
            error_log('Cloudinary upload cURL error: ' . $curlError);
            throw new RuntimeException('Unable to upload image to Cloudinary.');
        }

        $result = json_decode($response, true);
        if ($httpCode !== 200 || empty($result['secure_url']) || empty($result['public_id'])) {
            error_log('Cloudinary upload failed: ' . $response);
            throw new RuntimeException('Cloudinary image upload failed.');
        }

        return [
            'image_url' => $result['secure_url'],
            'public_id' => $result['public_id']
        ];
    }

    public function deleteImage($publicId)
    {
        if ($publicId === '') {
            return true;
        }

        $cloudName = $this->config['cloud_name'] ?? '';
        $apiKey = $this->config['api_key'] ?? '';
        $apiSecret = $this->config['api_secret'] ?? '';

        if ($cloudName === '' || $apiKey === '' || $apiSecret === '') {
            throw new RuntimeException('Cloudinary configuration is missing.');
        }

        $timestamp = time();
        $signature = sha1("public_id={$publicId}&timestamp={$timestamp}{$apiSecret}");
        $url = 'https://api.cloudinary.com/v1_1/' . rawurlencode($cloudName) . '/image/destroy';

        $curl = curl_init($url);
        curl_setopt_array($curl, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => [
                'public_id' => $publicId,
                'api_key' => $apiKey,
                'timestamp' => $timestamp,
                'signature' => $signature
            ],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT => 30
        ]);

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $curlError = curl_error($curl);
        curl_close($curl);

        if ($response === false) {
            error_log('Cloudinary delete cURL error: ' . $curlError);
            return false;
        }

        $result = json_decode($response, true);
        return $httpCode === 200 && in_array($result['result'] ?? '', ['ok', 'not found'], true);
    }
}
