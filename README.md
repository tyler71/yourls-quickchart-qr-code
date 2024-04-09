# yourls-quickchart-qr-code
Qr code plugin, using [Quickchart](https://quickchart.io/) - [Github](https://github.com/typpo/quickchart)

![screely-1712673264984](https://github.com/tyler71/yourls-quickchart-qr-code/assets/4926565/de6a1f4b-364c-44e1-b36c-ea3bb4874c54)

PHP plugin that generates QR codes using Quickchart's API.
## Features 

Menu Options:
- Customize suffix
- Customize Quickchart base domain (self-hosting)

## Menu Options
### Suffix
When this is typed at the end of the url, it will redirect to the QR code.

```text
Set to /qr
-> https://ln.example.com/qr
Set to .qr
-> https://ln.example.com.qr
```

### Quickchart Url

Base domain of Quickchart instance.
If you are hosting your own instance of quickchart, you may use this option to change the host.
When it redirects, it will redirect to your host instead

```text
Set to https://quickchart.example.com
-> Location: https://quickchart.example.com/qr?text=https://yourls.example.com.com/exampleshorturl
```
