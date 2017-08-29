# pagespeed+

Improve your TYPO3 page speed by using common best practices and other shenanigans :).

## Features

* HTTP/2 Server Push
* HTML Compression via [wyrihaximus/html-compress](https://github.com/WyriHaximus/HtmlCompress)
* JavaScript Compression via []()

## Configuration

You can use the constants editor or just overwrite the TypoScript like this:

```typoscript
plugin.tx_page_speed_plus {
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

### How to enable JavaScript compression

You can enable JavaScript compression by adding this to your configuration:

```typoscript
config.compressJs = 1
```

## License

MIT