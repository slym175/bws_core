<?php
namespace Bws\Core\Exceptions;

use Exception;

/**
 * Class RepositoryException
 * @package Prettus\Repository\Exceptions
 * @author Anderson Andrade <contato@andersonandra.de>
 */
class UpdateResourceException extends Exception
{
    protected $message = 'Can\'t update resource!';
}
