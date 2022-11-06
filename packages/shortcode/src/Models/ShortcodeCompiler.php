<?php

namespace Bws\Shortcode\Models;

use Illuminate\Support\Str;

class ShortcodeCompiler
{
    protected $enabled = false;

    protected $strip = false;

    protected $matches;

    protected $registered = [];

    protected $data = [];

    protected $_viewData;

    public function enable()
    {
        $this->enabled = true;
    }

    public function disable()
    {
        $this->enabled = false;
    }

    public function add($shortcode, $display_name, $group, $callback, $params = [])
    {
        $this->registered[$shortcode] = [
            'callback' => $callback,
            'group' => $group,
            'display_name' => $display_name,
            'params' => $params
        ];
    }

    public function attachData($data)
    {
        $this->data = $data;
    }

    public function compile($value)
    {
        // Only continue is laravel-shortcodes have been registered
        if (!$this->enabled || !$this->hasShortcodes()) {
            return $value;
        }

        // Set empty result
        $result = '';
        // Here we will loop through all of the tokens returned by the Zend lexer and
        // parse each one into the corresponding valid PHP. We will then have this
        // template as the correctly rendered PHP that can be rendered natively.
        foreach (token_get_all($value) as $token) {
            $result .= is_array($token) ? $this->parseToken($token) : $token;
        }

        return $result;
    }

    public function hasShortcodes()
    {
        return !empty($this->registered);
    }

    protected function parseToken($token)
    {
        list($id, $content) = $token;
        if ($id == T_INLINE_HTML) {
            $content = $this->renderShortcodes($content);
        }

        return $content;
    }

    protected function renderShortcodes($value)
    {
        $pattern = $this->getRegex();
        return preg_replace_callback("/{$pattern}/s", [$this, 'render'], $value);
    }

    public function viewData($viewData)
    {
        $this->_viewData = $viewData;
        return $this;
    }

    public function render($matches)
    {
        // Compile the shortcode
        $compiled = $this->compileShortcode($matches);
        $name = $compiled->getName();
        $viewData = $this->_viewData;
        $attributes = $this->parseAttributes($this->matches[3]);
        $callback_args = [
            'atts' => $attributes,
            'content' => $compiled->getContent() ? $compiled->getContent() : (isset($attributes['content']) && $attributes['content'] ? $attributes['content'] : ''),
            // $compiled,
            // $this,
            // $name,
            'view_data' => $viewData
        ];
        // Render the shortcode through the callback
        return call_user_func_array($this->getCallback($name), $callback_args);
    }

    protected function compileShortcode($matches)
    {
        // Set matches
        $this->setMatches($matches);
        // pars the attributes
        $attributes = $this->parseAttributes($this->matches[3]);

        // return shortcode instance
        return new Shortcode(
            $this->getName(),
            $this->getContent(),
            $attributes
        );
    }

    protected function setMatches($matches = [])
    {
        $this->matches = $matches;
    }

    public function getName()
    {
        return $this->matches[2];
    }

    public function getContent()
    {
        // Compile the content, to support nested laravel-shortcodes
        return $this->compile($this->matches[5]);
    }

    public function getData()
    {
        return $this->data;
    }

    public function getCallback($name)
    {
        // Get the callback from the laravel-shortcodes array
        $callback = $this->registered[$name]['callback'];
        // if is a string
        if (is_string($callback)) {
            // Parse the callback
            list($class, $method) = Str::parseCallback($callback, 'register');
            // If the class exist
            if (class_exists($class)) {
                // return class and method
                return [
                    app($class),
                    $method
                ];
            }
        }

        return $callback;
    }

    protected function parseAttributes($text)
    {
        // decode attribute values
        $text = htmlspecialchars_decode($text, ENT_QUOTES);

        $attributes = [];
        // attributes pattern
        $pattern = '/(\w+)\s*=\s*"([^"]*)"(?:\s|$)|(\w+)\s*=\s*\'([^\']*)\'(?:\s|$)|(\w+)\s*=\s*([^\s\'"]+)(?:\s|$)|"([^"]*)"(?:\s|$)|(\S+)(?:\s|$)/';
        // Match
        if (preg_match_all($pattern, preg_replace('/[\x{00a0}\x{200b}]+/u', " ", $text), $match, PREG_SET_ORDER)) {
            foreach ($match as $m) {
                if (!empty($m[1])) {
                    $attributes[strtolower($m[1])] = stripcslashes($m[2]);
                } elseif (!empty($m[3])) {
                    $attributes[strtolower($m[3])] = stripcslashes($m[4]);
                } elseif (!empty($m[5])) {
                    $attributes[strtolower($m[5])] = stripcslashes($m[6]);
                } elseif (isset($m[7]) && strlen($m[7])) {
                    $attributes[] = stripcslashes($m[7]);
                } elseif (isset($m[8])) {
                    $attributes[] = stripcslashes($m[8]);
                }
            }
        } else {
            $attributes = ltrim($text);
        }

        // return attributes
        return is_array($attributes) ? $attributes : ($attributes ? [$attributes] : []);
    }

    protected function getShortcodeNames()
    {
        return join('|', array_map('preg_quote', array_keys($this->registered)));
    }

    protected function getRegex()
    {
        $shortcodeNames = $this->getShortcodeNames();

        return "\\[(\\[?)($shortcodeNames)(?![\\w-])([^\\]\\/]*(?:\\/(?!\\])[^\\]\\/]*)*?)(?:(\\/)\\]|\\](?:([^\\[]*+(?:\\[(?!\\/\\2\\])[^\\[]*+)*+)\\[\\/\\2\\])?)(\\]?)";
    }

    public function strip($content)
    {
        if (empty($this->registered)) {
            return $content;
        }
        $pattern = $this->getRegex();

        return preg_replace_callback("/{$pattern}/s", [$this, 'stripTag'], $content);
    }

    public function getStrip()
    {
        return $this->strip;
    }

    public function setStrip($strip)
    {
        $this->strip = $strip;
    }

    protected function stripTag($m)
    {
        if ($m[1] == '[' && $m[6] == ']') {
            return substr($m[0], 1, -1);
        }

        return $m[1] . $m[6];
    }

    public function getRegistered()
    {
        return $this->registered;
    }
}
