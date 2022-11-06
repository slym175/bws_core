<?php
namespace Bws\Core\Exceptions;

use Exception;

/**
 * Class RepositoryException
 * @package Prettus\Repository\Exceptions
 * @author Anderson Andrade <contato@andersonandra.de>
 */
class CreateResourceException extends Exception
{
    protected $message = 'Can\'t create resource!';
}
