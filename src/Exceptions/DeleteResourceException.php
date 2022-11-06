<?php
namespace Bws\Core\Exceptions;

use Exception;

/**
 * Class RepositoryException
 * @package Prettus\Repository\Exceptions
 * @author Anderson Andrade <contato@andersonandra.de>
 */
class DeleteResourceException extends Exception
{
    protected $message = 'Can\'t delete resource!';
}
