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
        // First we will check if the URL is already a valid URL. If it is we will not
        // try to generate a new one but will simply return the URL as is, which is
        // convenient since developers do not always have to check if it's valid.
        if ($this->isValidUrl($path)) {
            return $path;
        }

        $scheme = $this->getScheme($secure);

        $extra = $this->formatParameters($extra);

        $tail = implode('/', array_map(
            'rawurlencode', (array) $extra)
        );

        // Once we have the scheme we will compile the "tail" by collapsing the values
        // into a single string delimited by slashes. This just makes it convenient
        // for passing the array of parameters to this URL as a list of segments.
        $root = $this->getRootUrl($scheme);

        $dottyQuery = http_build_query($this->getDottyParameters());

        if (($queryPosition = strpos($path, '?')) !== false) {
            $query = mb_substr($path, $queryPosition).'&'.$dottyQuery;
            $path = mb_substr($path, 0, $queryPosition);
        } else {
            $query = '?'.$dottyQuery;
        }

        return $this->trimUrl($root, $path, $tail).$query;
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
