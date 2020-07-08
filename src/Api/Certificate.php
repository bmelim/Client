<?php

declare(strict_types=1);

/*
 * This file is part of the DigitalOceanV2 library.
 *
 * (c) Antoine Corcy <contact@sbin.dk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DigitalOceanV2\Api;

use DigitalOceanV2\Entity\Certificate as CertificateEntity;
use DigitalOceanV2\Exception\HttpException;

/**
 * @author Jacob Holmes <jwh315@cox.net>
 */
class Certificate extends AbstractApi
{
    /**
     * @return CertificateEntity[]
     */
    public function getAll()
    {
        $certificates = $this->httpClient->get(sprintf('%s/certificates', $this->endpoint));

        $certificates = json_decode($certificates);

        $this->extractMeta($certificates);

        return array_map(function ($certificates) {
            return new CertificateEntity($certificates);
        }, $certificates->certificates);
    }

    /**
     * @param string $id
     *
     * @throws HttpException
     *
     * @return CertificateEntity
     */
    public function getById($id)
    {
        $certificate = $this->httpClient->get(sprintf('%s/certificates/%s', $this->endpoint, $id));

        $certificate = json_decode($certificate);

        return new CertificateEntity($certificate->certificate);
    }

    /**
     * @param string $name
     * @param string $privateKey
     * @param string $leafCertificate
     * @param string $certificateChain
     *
     * @throws HttpException
     *
     * @return CertificateEntity
     */
    public function create($name, $privateKey, $leafCertificate, $certificateChain)
    {
        $data = [
            'name' => $name,
            'private_key' => $privateKey,
            'leaf_certificate' => $leafCertificate,
            'certificate_chain' => $certificateChain,
        ];

        $certificate = $this->httpClient->post(sprintf('%s/certificates', $this->endpoint), $data);

        $certificate = json_decode($certificate);

        return new CertificateEntity($certificate->certificate);
    }

    /**
     * @param string $id
     *
     * @throws HttpException
     *
     * @return void
     */
    public function delete($id)
    {
        $this->httpClient->delete(sprintf('%s/certificates/%s', $this->endpoint, $id));
    }
}
