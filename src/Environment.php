<?php
/**
 * File description.
 *
 * PHP version 5
 *
 * @category -
 *
 * @author    -
 * @copyright -
 * @license   -
 */

namespace Javanile\Dotenv;

use Dotenv\Dotenv;

class Environment extends Dotenv
{
    /**
     * The file path.
     *
     * @var string
     */
    protected $fileExists;

    /**
     * Create a new dotenv instance.
     *
     * @param string $path
     * @param string $file
     *
     * @return void
     */
    public function __construct($path, $file = '.env')
    {
        parent::__construct($path, $file);
        $this->fileExists = file_exists($this->getFilePath($path, $file));
    }

    /**
     * Load silentily environment file in given directory.
     *
     * @return array
     */
    public function safeLoad()
    {
        if ($this->fileExists) {
            return $this->load();
        }
    }

    /**
     * Gets the value of an environment variable.
     *
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        $value = getenv($key);

        if ($value === false) {
            return $this->value($default);
        }

        switch (strtolower($value)) {
            case '(default)':
                return $this->value($default);
            case 'true':
            case '(true)':
                return true;
            case 'false':
            case '(false)':
                return false;
            case 'empty':
            case '(empty)':
                return '';
            case 'null':
            case '(null)':
                return;
        }

        if (strlen($value) > 1 && $value[0] == '"' && $value[strlen($value) - 1] == '"') {
            return substr($value, 1, -1);
        }

        return $value;
    }

    /**
     * Return the default value of the given value.
     *
     * @param  mixed  $value
     * @return mixed
     */
    private function value($value)
    {
        return $value instanceof Closure ? $value() : $value;
    }
}
