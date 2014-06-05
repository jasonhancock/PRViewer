#  PR Viewer

A simple tool to display open pull requests across organizations, users, or
individual repositories.

## Installation

## Configuration

Copy `config.php-dist` to `config.php`.

You will need to generate a Personal Access Token for each instance of GitHub
(public sites and enterprise instances) that you want to talk to. Go to
Account Settings > Applications > Generate New Personal Access Token.

Copy your Personal Access Token that you just generated into the `token` array
key for the appropriate GitHub instance in `config.php`:

```
<?php

return array(
    'time_zone'     => 'UTC',
    'jsonp_enabled' => true,
    'sites'         => array(
        array(
            'name'          => 'github.com',
            'token'         => 'YOUR TOKEN GOES HERE',
            'api_url'       => 'https://api.github.com/',
            'base_url'      => 'https://github.com/',
            'organizations' => array(),
            'exclude'       => array(),
            'include'       => array(),
            'users'         => array(
                'YOUR USERNAME GOES HERE'
            ),
        ),
    ),
);
```

### Using A GitHub Enterprise Instance

If you wish to query a GitHub enterprise instance in addition to the public
GitHub instance, add a new entry to the 'sites' array in `config.php`. If your
GitHub Enterprise instance is available at github.example.com, you would make
the following entries:

```
<?php

return array(
    'time_zone'     => 'UTC',
    'jsonp_enabled' => true,
    'sites'         => array(
        array(
            'name'          => 'github.example.com',
            'token'         => 'YOUR TOKEN GOES HERE',
            'api_url'       => 'https://github.example.com/api/v3/',
            'base_url'      => 'https://github.example.com/',
            'organizations' => array(),
            'exclude'       => array(),
            'include'       => array(),
            'users'         => array(),
        ),
        array(
            'name'          => 'github.com',
            'token'         => 'YOUR TOKEN GOES HERE',
            'api_url'       => 'https://api.github.com/',
            'base_url'      => 'https://github.com/',
            'organizations' => array(),
            'exclude'       => array(),
            'include'       => array(),
            'users'         => array(
                'YOUR USERNAME GOES HERE'
            ),
        ),
    ),
);
```

### Watching an Organization

### Watching a User

### Watching a specific repository

### Excluding repositories

## JSONP

If you'd rather render the results yourself in some other application, you can
use JSONP to fetch the data. Simply add a `callback=functioname` to a request
to api.php.

Example: Your dashboard is hosted at `http://example.com/prs/`,
and your callback function is called `handleprs`, you would want to add the following to your markup:

```
<script type="text/javascript" src="http://example.com/prs/api.php?callback=handleprs"></script>
```

### Disabling JSONP

If you want to turn off JSONP, set `jsonp_enabled` to false in the configuration file

## Development

## Contributing

## License: MIT

```
Copyright (c) 2014 Jason Hancock <jason@jasonhancock.com>

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
```
