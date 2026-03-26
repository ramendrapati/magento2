<?php
namespace Revest\Contact\Api;

/**
 * API interface for contact form submission
 */
interface ContactManagementInterface
{
    /**
     * Save contact request
     *
     * @param string $name
     * @param string $email
     * @param string $telephone
     * @param string $comment
     * @return bool
     */
public function save(string $name, string $email, string $telephone, string $comment): bool;
}