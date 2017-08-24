# TYPO3 pagespeed

Improve page speed by using common best practices and other shenanigans :).

## Features

* HTTP/2 Server Push
* HTML Compression via [wyrihaximus/html-compress](https://github.com/WyriHaximus/HtmlCompress)

## Configuration

You can use the constants editor or just overwrite the TypoScript like this:

```typoscript
plugin.tx_pagespeed {
    settings {
        http2 {
            serverPushEnable = 1
            maxHeaderLength = 8190
        }

        htmlCompress {
            enable = 1
        }
    }
}
```

## License

MIT