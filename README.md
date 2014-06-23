# jquery.autosuggest
***
Simple Auto-suggest plugin using jQuery on client side and PHP + MySQL on server side.


### Usage & API

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
