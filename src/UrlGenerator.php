<?php

namespace Lingxi\Dotty;

use Lingxi\Context\Context;
use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Routing\UrlGenerator as IlluminateUrlGenerator;

class UrlGenerator extends IlluminateUrlGenerator
{
    /**
     * Generate an absolute URL to the given path.
     *
     * @param  string  $path
     * @param  mixed  $extra
     * @param  bool|null  $secure
     * @return string
     */
    public function to($path, $extra = [], $secure = null)
    {
        if ($this->isValidUrl($path)) {
            return $path;
        }

        $tail = implode('/', array_map(
            'rawurlencode', (array) $this->formatParameters($extra))
        );

        // Once we have the scheme we will compile the "tail" by collapsing the values
        // into a single string delimited by slashes. This just makes it convenient
        // for passing the array of parameters to this URL as a list of segments.
        $root = $this->formatRoot($this->formatScheme($secure));

        list($path, $query) = $this->extractQueryString($path);

        $dottyQuery = http_build_query($this->getDottyParameters());

        if (($queryPosition = strpos($query, '?')) !== false) {
            $query .= '&'.$dottyQuery;
        } else {
            $query = '?'.$dottyQuery;
        }

        return $this->format(
            $root, '/'.trim($path.'/'.$tail, '/')
        ).$query;
    }

    protected function replaceRoutableParameters($parameters = [])
    {
        $parameters = is_array($parameters) ? $parameters : [$parameters];

        $parameters = array_merge($parameters, $this->getDottyParameters());

        foreach ($parameters as $key => $parameter) {
            if ($parameter instanceof UrlRoutable) {
                $parameters[$key] = $parameter->getRouteKey();
            }
        }

        return $parameters;
    }

    private function getDottyParameters()
    {
        return Context::create()->get('dotties');
    }
}
