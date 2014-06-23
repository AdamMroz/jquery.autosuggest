# jquery.autosuggest

Simple Auto-suggest plugin using jQuery on client side and PHP + MySQL on server side.


## Usage & API

Include jquery and plugin's js and css files:
```html
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="jquery.autosuggest.js"></script>
<link href="jquery.autosuggest.css" rel="stylesheet">
```

Call plugin:
```javascript
$('input').autosuggest({
	server: 'asg_server.php',
	delay: 600,
	start: 2
});
```

Get id of selected suggestion:
```javascript
var resultId = $('input').attr('data-id');
```
(data-id attribute is set to "0" if no suggestion is selected)

Options:

+ **server** - server-side file. *Default is **asg_server.php***
+ **delay** (ms) - hold ajax request until next key is pressed. *Default is **600***
+ **start** - start ajax requests after x characters. *Default is **2***
