<?php
/**
 * This file is part of the Elephant.io package
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 *
 * @copyright Wisembly
 * @license   http://www.opensource.org/licenses/MIT-License MIT License
 */

namespace TungstenVn\Socket\elephantio\src\Exception;

use Exception;
use RuntimeException;

class ServerConnectionFailureException extends RuntimeException
{
    /** @var string php error message */
    private $errorMessage;

    public function __construct($errorMessage, Exception $previous = null)
    {
        parent::__construct('An error occurred while trying to establish a connection to the server', 0, $previous);

        $this->errorMessage = $errorMessage;
    }

    public function getErrorMessage()
    {
        return $this->errorMessage;
    }
}
